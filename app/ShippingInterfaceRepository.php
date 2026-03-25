<?php

namespace App;

interface ShippingInterfaceRepository
{
    public function searchForCepAddress(string $cep);
    public function searchForAddressCoordinates(array $address);
    public function calculateShippingCostForTwoDistances(array $ceps);
}
