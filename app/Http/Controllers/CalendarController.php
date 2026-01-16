<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\WarehouseMovement;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index()
    {   
        // recuperiamo i movimenti con recipe e product
        $rows = DB::table('warehouse_movements as wm')
        ->leftJoin('recepies as r', 'wm.recepy_id', '=', 'r.id')
        ->leftJoin('products as p', 'wm.product_id', '=', 'p.id')
        ->leftJoin('product_recepy as pr', function ($join) {
            $join->on('pr.recepy_id', '=', 'wm.recepy_id')
                ->on('pr.product_id', '=', 'wm.product_id');
        })
        ->select(
            'wm.id',
            'wm.date',
            'wm.type',
            'wm.before_quantity',
            'wm.after_quantity',
            'r.name as recepy_name',
            'p.name as product_name',
            'p.price',
            'pr.grams_used'
        )
        ->orderBy('wm.date')
        ->get();

            $warehouseMovements = $rows
        ->groupBy(fn($r) => ($r->recepy_name ?? 'manuale') . '|' . $r->date)
        ->map(function ($group) {

            $first = $group->first();

            $details = $group->map(function ($row) {

                // quantità usata corretta
                if ($row->type === 'stock_out') {
                    $grams = $row->after_quantity - $row->before_quantity;
                } else {
                    $grams = max(0, $row->after_quantity - $row->before_quantity);
                }

                $spent = ($grams / 1000) * ($row->price ?? 0);

                return [
                    'product' => $row->product_name ?? 'N/D',
                    'quantity' => $grams,
                    'before_quantity' => $row->before_quantity,
                    'after_quantity' => $row->after_quantity,
                    'spent' => round($spent, 2),
                    'row_class' => $row->after_quantity < $row->before_quantity
                        ? 'row-out'
                        : 'row-in',
                ];
            })->values();

            $totalBefore = $details->sum('before_quantity');
            $totalAfter  = $details->sum('after_quantity');
            
            return [
                'id'    => $first->id,
                'start' => $first->date,
                'end'   => $first->date,
                'title' => 'Registrazione ' . ($first->recepy_name ?? 'Manuale'),
                'class' => $first->type === 'stock_out' ? 'event-out' : 'event-in',
                'details' => $details,
            ];
        })
        ->values()
        ->toArray();

        // dump($warehouseMovements);
        
        return Inertia::render('Calendar', [
            'warehouseMovements' => $warehouseMovements
        ]);
    }
}
