<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   

        $query = Order::with(['store', 'supplier', 'products']);

        if ($request->filled('store')) {
            $query->where('store_id', $request->store);
        }

        $orders = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString(); // mantiene i filtri nella paginazione

        return Inertia::render('Admin/Orders/IndexOrders', [
            'orders' => $orders, 
            'stores'    => Store::select('id', 'name')->get(),
            'filters'   => $request->only(['store']),
            'columns' => [
                ['text' => 'ID', 'value' => 'id'],
                ['text' => 'Negozio', 'value' => 'store.name'],
                ['text' => 'Fornitore', 'value' => 'supplier.name'],
                ['text' => 'Prodotti', 'value' => 'products'],
                ['text' => 'Totale', 'value' => 'total'],
            ],
            'toast' => session('toast')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Ordine cancellato con successo'
            ]
        ]);
    }
}
