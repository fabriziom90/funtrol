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
            if ($user->role === 'superadmin') {
                return;
            }

            $storeId = optional($user->store)->id;

            if (!$storeId) {
                return;
            }

            $builder->where('store_id', $storeId);
        });

        // Imposta automaticamente store_id in fase di creazione
        static::creating(function ($model) {

            if (!auth()->check()) {
                return;
            }

            $user = auth()->user();

            if ($user->role === 'superadmin') {
                return;
            }

            $storeId = optional($user->store)->id;

            if ($storeId) {
                $model->store_id = $storeId;
            }
        });
    }
}