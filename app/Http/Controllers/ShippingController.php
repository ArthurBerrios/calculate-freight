<?php

namespace App\Http\Controllers;

use App\Http\Services\ShippingService;
use App\Models\User;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __construct(
        private ShippingService $shippingService,
    )
    {}
    public function calculation(Request $request)
    {
        $ceps = $request->all();
        
        return $this->shippingService->calculateShippingCostForTwoDistances($ceps);

    }
    public function updatePricePerKm(User $user, Request $request)
    {
        $user->update([
            'price_per_km' => $request->price_per_km
        ]);

        return $user;
    }
}
