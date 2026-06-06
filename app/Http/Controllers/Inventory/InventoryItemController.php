<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryItemController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index(Request $request)
    {
        $query = InventoryItem::where('branch_id', $this->branchId());

        // Quick filter from dashboard ?filter=low
        if ($request->filter === 'low') {
            $query->whereNotNull('min_quantity')
                ->where('min_quantity', '>', 0)
                ->whereColumn('quantity', '<=', 'min_quantity');
        }

        $items = $query->orderBy('name')->get();

        return view('app.inventory.items.index', compact('items'));
    }

    public function create()
    {
        return view('app.inventory.items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'category'     => 'nullable|string|max:50',
            'quantity'     => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:0',
            'unit'         => 'nullable|string|max:20',
            'location'     => 'nullable|string|max:100',
            'description'  => 'nullable|string',
        ]);

        $data['branch_id'] = $this->branchId();
        InventoryItem::create($data);

        return redirect()->route('inventory.items.index')
            ->with('message', 'Item added to inventory.')->with('alert-type', 'success');
    }

    public function show(InventoryItem $item)
    {
        $item->load(['transactions' => fn ($q) => $q->with('user')->orderByDesc('created_at')]);
        return view('app.inventory.items.show', compact('item'));
    }

    public function edit(InventoryItem $item)
    {
        return view('app.inventory.items.edit', compact('item'));
    }

    public function update(Request $request, InventoryItem $item)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'category'     => 'nullable|string|max:50',
            'quantity'     => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:0',
            'unit'         => 'nullable|string|max:20',
            'location'     => 'nullable|string|max:100',
            'description'  => 'nullable|string',
        ]);

        $item->update($data);

        return redirect()->route('inventory.items.index')
            ->with('message', 'Item updated.')->with('alert-type', 'success');
    }

    public function destroy(InventoryItem $item)
    {
        $item->delete();

        return redirect()->route('inventory.items.index')
            ->with('message', 'Item deleted.')->with('alert-type', 'success');
    }
}
