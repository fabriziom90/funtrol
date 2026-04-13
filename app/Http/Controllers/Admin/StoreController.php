<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::with('store')->where('role', '!=', 'superadmin');
        $users = $query->orderBy('id', 'desc')->paginate(10);
        return Inertia::render('Admin/Stores/IndexStores', [
            'users' => $users,
            'columns' => [
                ['text' => 'ID', 'value' => 'id'],
                ['text' => 'Email utente', 'value' => 'email'],
                ['text' => 'Negozio', 'value' => 'store.name'],
                ['text' => 'Proprietario', 'value' => 'store.owner_name'],
                ['text' => 'Email negozio', 'value' => 'store.email'],
            ],
            'toast' => session('toast')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Stores/CreateStore');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {

            // Creazione utente
            $user = User::create([
                'email' => $data['user']['email'],
                'password' => Hash::make($data['user']['password']),
                'role' => UserRole::USER
            ]);

            // Creazione store collegato
            Store::create([
                'name' => $data['store']['name'],
                'owner_name' => $data['store']['owner_name'],
                'email' => $data['store']['email'],
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('admin.stores.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Negozio creato con successo.'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        $user = $store->user;

        return Inertia::render('Admin/Stores/EditStore', ['store' => $store, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $store) {

            // Aggiorna store
            $store->update([
                'name' => $data['store']['name'],
                'owner_name' => $data['store']['owner_name'],
                'email' => $data['store']['email'],
            ]);

            // Utente collegato
            $user = $store->user;

            // Aggiorna email
            $user->email = $data['user']['email'];

            // Aggiorna password SOLO se compilata
            if (!empty($data['user']['password'])) {
                $user->password = Hash::make($data['user']['password']);
            }

            $user->save();
        });

        return redirect()->route('admin.stores.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Negozio aggiornato con successo.'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        $user = $store->user;

        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.stores.index')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'Utente eliminato con successo'
            ]
        ]);
    }
}
