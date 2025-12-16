<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Recepy;
use App\Models\Product;
use App\Models\WarehouseMovement;

class ProductionController extends Controller
{
    public function index()
    {   
        $recepies = Recepy::all();
        
        return Inertia::render('Recepies', ['recepies' => $recepies,  'toast' => session('toast'), 'critical_count' => session('critical_count')]);
    }

    public function update(Request $request)
    {
        $form_data = $request->all();
        $quantities = $form_data['quantities'];
    
         $criticalProducts = [];

        foreach ($quantities as $item) {
            $recepy = Recepy::with('products')->find($item['recepy_id']);
            $producedQuantity = $item['quantity'];

            if (!$recepy || $producedQuantity <= 0) continue;

            
            foreach ($recepy->products as $product) {
                $required = $product->pivot->grams_used * $producedQuantity;

                if ($product->grams_in_warehouse < $required) {
                    $insufficientRecipes[] = $recepy->name;
                    continue 2; 
                }
            }
            

            foreach ($recepy->products as $product) {

                $gramsPerUnit = $product->pivot->grams_used;
                $gramsToSubtract = $gramsPerUnit * $producedQuantity;

                // prima
                $before = $product->grams_in_warehouse;

                // sottrazione
                $product->grams_in_warehouse = max(0, $before - $gramsToSubtract);
                $product->save();

                // dopo
                $after = $product->grams_in_warehouse;

                if($producedQuantity > 0){
                    // 🔥 registra movimento
                    WarehouseMovement::create([
                        'type'           => 'stock_out',
                        'quantity'       => $gramsToSubtract,
                        'before_quantity'=> $before,
                        'after_quantity' => $after,
                        'product_id'     => $product->id,
                        'recepy_id'      => $recepy->id,
                        'date'           => now(),
                        'note'           => "Produzione di {$producedQuantity} x {$recepy->name}",
                        'user_id'        => auth()->id(),
                    ]);
    
                    if ($after < $product->min_stock) {
                        $criticalProducts[$product->id] = $product;
                    }
                }
            }
        }

        return redirect()->route('production.index')->with([
            'critical_count' => count($criticalProducts),
            'toast' => !empty($insufficientRecipes)
            ? [
                'type' => 'error',
                'message' => 'Ingredienti insufficienti per: ' . implode(', ', $insufficientRecipes)
              ]
            : [
                'type' => 'success',
                'message' => 'Produzione registrata con successo.'
              ]
        ]);
    }

}
