<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['products', 'supplier'])->orderBy('date_order')->get();

        return Inertia::render('Admin/Orders/IndexOrders', [
            'orders' => $orders, 
            'columns' => [
                ['text' => 'ID', 'value' => 'id'],
                ['text' => 'Fornitore', 'value' => 'supplier'],
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

        return redirect()->route('admin.orders.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Ordine cancellato con successo'
            ]
        ]);
    }
}
