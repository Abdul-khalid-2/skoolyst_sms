<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        if (InventoryItem::count() > 0) {
            $this->command->info('Inventory data already seeded. Skipping.');
            return;
        }

        $branchId = Branch::query()->value('id') ?? 1;
        $admin    = User::role('admin')->first() ?? User::role('super-admin')->first();
        $adminId  = $admin?->id;

        // ── 1. Items ──────────────────────────────────────────────────────────────
        // [name, category, unit, location, min_quantity, opening_qty]
        $itemDefs = [
            ['Whiteboard Marker',      'Stationery',        'box',    'Store Room A', 10, 45],
            ['A4 Paper Ream',          'Stationery',        'ream',   'Store Room A', 20, 120],
            ['Ballpoint Pen',          'Stationery',        'dozen',  'Store Room A', 15, 8],   // low
            ['Stapler',                'Stationery',        'piece',  'Store Room A', 5,  18],
            ['File Folder',            'Stationery',        'pack',   'Store Room A', 10, 30],
            ['Student Desk',           'Furniture',         'piece',  'Warehouse',    5,  60],
            ['Office Chair',           'Furniture',         'piece',  'Warehouse',    5,  3],   // low
            ['Notice Board',           'Furniture',         'piece',  'Warehouse',    3,  12],
            ['Projector',              'Electronics',       'piece',  'IT Lab',       2,  6],
            ['HDMI Cable',             'IT Equipment',      'piece',  'IT Lab',       10, 0],   // out
            ['Desktop Computer',       'IT Equipment',      'set',    'IT Lab',       3,  25],
            ['UPS Battery',            'IT Equipment',      'piece',  'IT Lab',       4,  4],   // low (at min)
            ['Microscope',            'Lab Equipment',      'piece',  'Science Lab',  3,  15],
            ['Test Tube',              'Lab Equipment',     'box',    'Science Lab',  10, 40],
            ['Bunsen Burner',          'Lab Equipment',     'piece',  'Science Lab',  5,  9],
            ['Football',               'Sports Equipment',  'piece',  'Sports Room',  6,  14],
            ['Cricket Bat',            'Sports Equipment',  'piece',  'Sports Room',  4,  2],   // low
            ['Floor Cleaner',          'Cleaning Supplies', 'bottle', 'Janitor Room', 12, 35],
            ['Broom',                  'Cleaning Supplies', 'piece',  'Janitor Room', 8,  22],
            ['First Aid Kit',          'Medical',           'set',    'Sick Room',    3,  7],
        ];

        $items = [];
        foreach ($itemDefs as [$name, $category, $unit, $location, $min, $qty]) {
            $items[] = InventoryItem::create([
                'branch_id'    => $branchId,
                'name'         => $name,
                'category'     => $category,
                'quantity'     => $qty,
                'min_quantity' => $min,
                'unit'         => $unit,
                'location'     => $location,
                'description'  => null,
            ]);
        }

        $this->command->info('✓ ' . count($items) . ' inventory items created.');

        // ── 2. Transactions ───────────────────────────────────────────────────────
        // Build a plausible movement history that nets to the current quantity.
        $txnCount = 0;
        $today    = Carbon::today();

        foreach ($items as $item) {
            // Opening purchase — slightly more than current to allow some issues/damage
            $openingQty = $item->quantity + rand(5, 20);

            InventoryTransaction::create([
                'branch_id'        => $branchId,
                'item_id'          => $item->id,
                'user_id'          => $adminId,
                'quantity'         => $openingQty,
                'transaction_type' => 'purchase',
                'reference_number' => 'PO-' . strtoupper(Str::random(6)),
                'notes'            => 'Opening stock purchase',
                'created_at'       => (clone $today)->subDays(rand(60, 90)),
                'updated_at'       => (clone $today)->subDays(rand(60, 90)),
            ]);
            $txnCount++;

            // A few movements that bring it down to current quantity
            $running = $openingQty;
            $movements = rand(1, 4);

            for ($m = 0; $m < $movements && $running > $item->quantity; $m++) {
                $maxOut = $running - $item->quantity;
                if ($maxOut <= 0) break;

                $type = ['issue', 'issue', 'damage'][array_rand([0, 1, 2])];
                $out  = min($maxOut, rand(1, max(1, (int) ($maxOut / 2)) ?: 1));

                InventoryTransaction::create([
                    'branch_id'        => $branchId,
                    'item_id'          => $item->id,
                    'user_id'          => $adminId,
                    'quantity'         => $out,
                    'transaction_type' => $type,
                    'reference_number' => strtoupper(substr($type, 0, 3)) . '-' . strtoupper(Str::random(5)),
                    'notes'            => $type === 'damage' ? 'Damaged / unusable' : 'Issued to department',
                    'created_at'       => (clone $today)->subDays(rand(1, 55)),
                    'updated_at'       => (clone $today)->subDays(rand(1, 55)),
                ]);
                $running -= $out;
                $txnCount++;
            }

            // Reconcile any remaining gap with a final issue so history matches quantity
            if ($running > $item->quantity) {
                InventoryTransaction::create([
                    'branch_id'        => $branchId,
                    'item_id'          => $item->id,
                    'user_id'          => $adminId,
                    'quantity'         => $running - $item->quantity,
                    'transaction_type' => 'issue',
                    'reference_number' => 'ISS-' . strtoupper(Str::random(5)),
                    'notes'            => 'Issued to department',
                    'created_at'       => (clone $today)->subDays(rand(1, 30)),
                    'updated_at'       => (clone $today)->subDays(rand(1, 30)),
                ]);
                $txnCount++;
            }
        }

        $this->command->info("✓ {$txnCount} inventory transactions created.");
    }
}
