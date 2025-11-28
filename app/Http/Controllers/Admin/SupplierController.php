<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return Inertia::render('Admin/Supplier/IndexSupplier', ['suppliers' => $suppliers, 'columns' => [
            ['text' => 'ID', 'value' => 'id'],
            ['text' => 'Nome', 'value' => 'name'],
            ['text' => 'Email', 'value' => 'email'],
            ['text' => 'Telefono', 'value' => 'phone'],
        ],
        'toast' => session('toast')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Supplier/CreateSupplier');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $form_data = $request->validated();

        $newSupplier = new Supplier();
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
        return Inertia::render('Admin/Supplier/EditSupplier', ['supplier' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $form_data = $request->validated();

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
