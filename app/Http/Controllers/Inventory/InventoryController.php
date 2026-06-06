<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index()
    {
        $branchId = $this->branchId();

        $totalItems = InventoryItem::where('branch_id', $branchId)->count();
        $totalStock = InventoryItem::where('branch_id', $branchId)->sum('quantity');

        $lowStock = InventoryItem::where('branch_id', $branchId)
            ->whereNotNull('min_quantity')
            ->where('min_quantity', '>', 0)
            ->whereColumn('quantity', '<=', 'min_quantity')
            ->where('quantity', '>', 0)
            ->count();

        $outOfStock = InventoryItem::where('branch_id', $branchId)
            ->where('quantity', '<=', 0)
            ->count();

        $lowStockItems = InventoryItem::where('branch_id', $branchId)
            ->whereNotNull('min_quantity')
            ->where('min_quantity', '>', 0)
            ->whereColumn('quantity', '<=', 'min_quantity')
            ->orderBy('quantity')
            ->limit(10)
            ->get();

        $recentTransactions = InventoryTransaction::where('branch_id', $branchId)
            ->with(['item', 'user'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('app.inventory.index', compact(
            'totalItems', 'totalStock', 'lowStock', 'outOfStock',
            'lowStockItems', 'recentTransactions'
        ));
    }
}
