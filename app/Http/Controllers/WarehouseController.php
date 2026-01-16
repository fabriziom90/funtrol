<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Models\WarehouseMovement;
use App\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\ProductOrdered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class WarehouseController extends Controller
{
    public function index()
    {
        $products = Product::with(['supplier'])->orderByRaw('(grams_in_warehouse < min_stock) DESC')->get();
        
        return Inertia::render('Warehouse', ['products' => $products, 'toast' => session('toast'), 'authUser' => Auth::user()]);
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

    public function storeOrder(StoreOrderRequest $request){
        $form_data = $request->validated();

        DB::transaction(function () use ($form_data) {

            $total = collect($form_data['products'])->sum(function ($p) {
                return ($p['quantity'] / 1000) * $p['unit_price'];
            });

            $order = Order::create([
                'supplier_id' => $form_data['supplier_id'],
                'total' => $total,
                'date_order' => now(),
            ]);

            foreach ($form_data['products'] as $item) {
                ProductOrdered::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }
        });

        return back()->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Ordine registrato correttamente',
            ]
        ]);
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
        $form_data = $request->all();
        $data = $request->validate([
            'to'      => ['required', 'email'],
            'subject' => ['required', 'string'],
            'body'    => ['required', 'string'],
        ]);
        
        DB::transaction(function () use ($form_data) {

            $total = collect($form_data['products'])->sum(fn ($p) =>
                ($p['quantity'] / 1000) * $p['unit_price']
            );

            $order = Order::create([
                'supplier_id' => $form_data['supplier_id'],
                'total' => $total,
                'date_order' => now(),
            ]);

            foreach ($form_data['products'] as $item) {
                ProductOrdered::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }
        });

        Mail::raw($form_data['body'], function ($message) use ($form_data) {
            $user = auth()->user();

            $message
                ->from($user->email, $user->name)
                ->to($form_data['to'])
                ->subject($form_data['subject']);
        });

        return back()->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Ordine registrato e mail inviata correttamente',
            ]
        ]);
    
    }
}
