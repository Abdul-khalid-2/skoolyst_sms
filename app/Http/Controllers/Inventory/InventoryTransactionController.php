<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryTransactionController extends Controller
{
    /** Transaction types that increase stock. */
    private const STOCK_IN = ['purchase', 'return', 'adjustment'];

    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index(Request $request)
    {
        $query = InventoryTransaction::where('branch_id', $this->branchId())
            ->with(['item', 'user']);

        if ($request->filled('item')) {
            $query->whereHas('item', fn ($q) =>
                $q->where('name', 'like', '%' . $request->item . '%'));
        }
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }

        $transactions = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('app.inventory.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = InventoryItem::where('branch_id', $this->branchId())->orderBy('name')->get();
        return view('app.inventory.transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id'          => 'required|exists:inventory_items,id',
            'transaction_type' => 'required|in:purchase,issue,return,adjustment,damage',
            'quantity'         => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:50',
            'notes'            => 'nullable|string',
        ]);

        $item   = InventoryItem::findOrFail($data['item_id']);
        $isIn   = in_array($data['transaction_type'], self::STOCK_IN);

        // Guard: cannot remove more than available
        if (! $isIn && $data['quantity'] > $item->quantity) {
            return back()->withInput()
                ->with('message', "Cannot remove {$data['quantity']} — only {$item->quantity} {$item->unit} in stock.")
                ->with('alert-type', 'error');
        }

        DB::transaction(function () use ($data, $item, $isIn) {
            InventoryTransaction::create([
                'branch_id'        => $this->branchId(),
                'item_id'          => $item->id,
                'user_id'          => Auth::id(),
                'quantity'         => $data['quantity'],
                'transaction_type' => $data['transaction_type'],
                'reference_number' => $data['reference_number'] ?? null,
                'notes'            => $data['notes'] ?? null,
            ]);

            $item->increment('quantity', $isIn ? $data['quantity'] : -$data['quantity']);
        });

        return redirect()->route('inventory.transactions.index')
            ->with('message', 'Stock transaction recorded.')->with('alert-type', 'success');
    }
}
