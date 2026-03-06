<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToStore
{
    protected static function bootBelongsToStore()
    {
        static::addGlobalScope('store', function (Builder $builder) {

            // Se non autenticato → non filtrare
            if (!auth()->check()) {
                return;
            }

            $user = auth()->user();

            // Se superadmin → nessun filtro
            if ($user->store_id === null) {
                return;
            }

            // Owner → filtra per store
            $builder->where('store_id', $user->store_id);
        });

        // Imposta automaticamente store_id in fase di creazione
        static::creating(function ($model) {

            if (!auth()->check()) {
                return;
            }

            $user = auth()->user();

            if ($user->store_id === null) {
                return;
            }

            if ($user->role !== 'superadmin') {
                $model->store_id = $user->store_id;
            }
        });
    }
}