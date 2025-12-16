<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),

            ],
            [
                'toast' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'critical_count' => fn () => $request->session()->get('critical_count', 0),
                'critical_products' => fn () => $request->session()->get('critical_products', []),
            ]
        ];
    }
}
