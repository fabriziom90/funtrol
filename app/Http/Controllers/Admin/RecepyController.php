<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecepyRequest;
use App\Http\Requests\UpdateRecepyRequest;
use App\Models\Product;
use App\Models\Recepy;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Store;

class RecepyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Recepy::with(['store']);

        if ($request->filled('store')) {
            $query->where('store_id', $request->store);
        }

        $recepies = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString(); // mantiene i filtri nella paginazione

        return Inertia::render('Admin/Recepies/IndexRecepies', [
            'recepies' => $recepies, 
            'columns' => [
                ['text' => 'ID', 'value' => 'id'],
                ['text' => 'Nome', 'value' => 'name'],
                ['text' => 'Descrizione', 'value' => 'description'],
                ['text' => 'Negozio', 'value' => 'store.name']
            ],
            'stores' => Store::select('id','name')->get(), // per select filtro
            'filters' => $request->only(['store']),
            'toast' => session('toast')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $stores = Store::all();
        return Inertia::render('Admin/Recepies/CreateRecepy', ['products' => $products, 'stores' => $stores]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecepyRequest $request)
    {
        $form_data = $request->validated();
        
        $newRecepy = new Recepy();
        $newRecepy->name = $form_data['name'];
        $newRecepy->unit = $request->get('unit');
        $newRecepy->description = $form_data['description'];
        $newRecepy->price = $form_data['price'];
        $newRecepy->store_id = $form_data['store_id'];

        $newRecepy->save();

        if (isset($form_data['ingredients'])) {
            foreach ($form_data['ingredients'] as $product) {
                $newRecepy->products()->attach($product['product_id'], ['grams_used' => $product['grams']]);
            }
        }

        return redirect()->route('admin.recepies.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => "Ricetta creata con successo."
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recepy $recepy)
    {   
        return Inertia::render('Admin/Recepies/ShowRecepy', ['recepy' => $recepy->load('products')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recepy $recepy)
    {
        $products = Product::all();
        $stores = Store::all();
        return Inertia::render('Admin/Recepies/EditRecepy', ['recepy' => $recepy->load('products'), 'products' => $products, 'stores' => $stores]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecepyRequest $request, Recepy $recepy)
    {
        $form_data = $request->validated();

        $recepy->name = $form_data['name'];
        $recepy->unit = $request->get('unit');
        $recepy->description = $form_data['description'];
        $recepy->price = $form_data['price'];
        $recepy->store_id = $form_data['store_id'];
        // dd($form_data);
        $recepy->save();

        if (isset($form_data['ingredients'])) {
            $pivotData = [];

            foreach ($form_data['ingredients'] as $ingredient) {
                // Evita ingredienti senza prodotto
                if (!isset($ingredient['product_id']) || !$ingredient['product_id']) {
                    continue;
                }

                $pivotData[$ingredient['product_id']] = [
                    'grams_used' => $ingredient['grams_used'],
                ];
            }

            // Rimuove ingredienti non più presenti, aggiorna quelli esistenti, aggiunge nuovi ingredienti
            $recepy->products()->sync($pivotData);
        }

        return redirect()->route('admin.recepies.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => "Ricetta aggiornata con successo."
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recepy $recepy)
    {
        $recepy->delete();
        return redirect()->route('admin.recepies.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Ricetta eliminata con successo'
            ]
        ]);
    }
}
