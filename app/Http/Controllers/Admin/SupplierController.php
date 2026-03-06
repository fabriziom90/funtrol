<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::with(['store']);

        if ($request->filled('store')) {
            $query->where('store_id', $request->store);
        }

        $suppliers = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Supplier/IndexSupplier', ['suppliers' => $suppliers, 'columns' => [
            ['text' => 'ID', 'value' => 'id'],
            ['text' => 'Negozio', 'value' => 'store.name'],
            ['text' => 'Nome', 'value' => 'name'],
            ['text' => 'Email', 'value' => 'email'],
            ['text' => 'Telefono', 'value' => 'phone'],
        ],
        'stores' => Store::select('id','name')->get(), // per select filtro
        'filters' => $request->only(['store']),
        'toast' => session('toast')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $stores = Store::all();
        return Inertia::render('Admin/Supplier/CreateSupplier', ['stores' => $stores]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $form_data = $request->validated();

        $newSupplier = new Supplier();
        $newSupplier->store_id = $form_data['store_id'];
        $newSupplier->name = $form_data['name'];
        $newSupplier->email = $form_data['email'];
        $newSupplier->phone = $form_data['phone'];

        $newSupplier->save();

        return redirect()->route('admin.suppliers.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => "Fornitore creato con successo."
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {   
        $stores = Store::all();
        return Inertia::render('Admin/Supplier/EditSupplier', ['supplier' => $supplier, 'stores' => $stores]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $form_data = $request->validated();

        $supplier->store_id = $form_data['store_id'];
        $supplier->name = $form_data['name'];
        $supplier->email = $form_data['email'];
        $supplier->phone = $form_data['phone'];

        $supplier->save();

        return redirect()->route('admin.suppliers.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Fornitore modificato con successo'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with([
            'toast' => [
                'type'      => 'success',
                'message'  => 'Fornitore cancellato con successo'
            ]
        ]);
    }
}
