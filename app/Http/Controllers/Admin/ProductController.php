<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Supplier;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $products = Product::with(['supplier'])->get();
        return Inertia::render('Admin/Products/IndexProducts', [
            'products' => $products, 
            'columns' => [
                ['text' => 'ID', 'value' => 'id'],
                ['text' => 'Nome', 'value' => 'name'],
                ['text' => 'Prezzo', 'value' => 'price'],
                ['text' => 'Fornitore', 'value' => 'supplier'],
                ['text' => 'Quantità (gr) in magazzino', 'value' => 'grams_in_warehouse'],
            ],
            'toast' => session('toast')]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return Inertia::render('Admin/Products/CreateProduct', ['suppliers' => $suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $form_data = $request->validated();

        $newProduct = new Product();
        $newProduct->name = $form_data['name'];
        $newProduct->price = $form_data['price'];
        $newProduct->supplier_id = $form_data['supplier_id'];
        $newProduct->grams_in_warehouse = $form_data['grams_in_warehouse'];

        $newProduct->save();

        return redirect()->route('admin.products.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Prodotto inserito con successo.'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {   
        $suppliers = Supplier::all();
        return Inertia::render('Admin/Products/EditProduct', ['suppliers' => $suppliers, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $form_data = $request->validated();
        
        $product->name = $form_data['name'];
        $product->price = $form_data['price'];
        $product->supplier_id = $form_data['supplier_id'];
        $product->grams_in_warehouse = $form_data['grams_in_warehouse'];

        $product->save();

        return redirect()->route('admin.products.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Prodotto aggiornato con successo.'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Prodotto eliminato con successo.'
            ]
        ]);
    }
}
