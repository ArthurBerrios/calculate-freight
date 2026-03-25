<?php
namespace App\Http\Services;

use App\Http\Repositories\ShippingRepository;

class ShippingService
{
    public function __construct(
        private ShippingRepository $shippingRepository,
    )
    {}
    public function searchForCepAddress(string $cep)
    {
        return $this->shippingRepository->searchForCepAddress($cep);
    }
    public function searchForAddressCoordinates(array $address)
    {
        return $this->shippingRepository->searchForAddressCoordinates($address);
    }
    public function calculateShippingCostForTwoDistances(array $ceps)
    {
        return $this->shippingRepository->calculateShippingCostForTwoDistances($ceps);
    }
}