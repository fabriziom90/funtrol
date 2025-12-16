<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Models\WarehouseMovement;


class WarehouseController extends Controller
{
    public function index()
    {
        $products = Product::with(['supplier'])->orderByRaw('(grams_in_warehouse < min_stock) DESC')->get();

        return Inertia::render('Warehouse', ['products' => $products, 'toast' => session('toast')]);
    }

    public function storeIncomingOrder(Request $request)
    {
        foreach ($request->products as $item) {

            $product = Product::find($item['product_id']);
            $added = $item['quantity']; // sempre in grammi

            if (!$product || $added <= 0) continue;

            $before = $product->grams_in_warehouse;
            $after = $before + $added;

            $product->grams_in_warehouse = $after;
            $product->save();

            WarehouseMovement::create([
                'type'           => 'order_in',
                'quantity'       => $added,
                'before_quantity'=> $before,
                'after_quantity' => $after,
                'product_id'     => $product->id,
                'recepy_id'      => null,
                'date'           => now(),
                'note'           => "Carico da ordine fornitore {$product->supplier->name}",
                'user_id'        => auth()->id(),
            ]);
        }
    }

    public function updateProductQuantity(Request $request)
    {
        $form_data = $request->all();
        
        $quantity = $form_data['grams_in_warehouse'];
        $product_id = $form_data['product'];

        $product = Product::findOrFail($product_id);

        $before_quantity = $product->grams_in_warehouse;

        $after_quantity = $before_quantity + $quantity;

        $product->grams_in_warehouse = $after_quantity;

        $product->save();

        WarehouseMovement::create([
            'type' => 'stock_in',
            'quantity'  => $quantity,
            'before_quantity'   => $before_quantity,
            'after_quantity'    => $after_quantity,
            'product_id'        => $product->id,
            'recepy_id'         => null,
            'date'              => now(),
            'note'              => 'Caricamento manuale in magazzino',
            'user_id'           => auth()->id()
        ]);

        return redirect()->back()->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Quantità aggiornata correttamente'
            ]
        ]);
    }

    public function sendSupplierEmail(Request $request)
    {
        $data = $request->validate([
            'to'      => ['required', 'email'],
            'subject' => ['required', 'string'],
            'body'    => ['required', 'string'],
        ]);

        Mail::raw($data['body'], function ($message) use ($data) {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });

        return back()->with([
            'success' => true,
            'message' => 'Email inviata con successo.',
        ]);
    
    }
}
