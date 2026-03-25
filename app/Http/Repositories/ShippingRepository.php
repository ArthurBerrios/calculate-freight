<?php 
namespace App\Http\Repositories;

use App\ShippingInterfaceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number;

class ShippingRepository implements ShippingInterfaceRepository
{
    public function searchForCepAddress(string $cep)
    {
        $response = Http::get("https://brasilapi.com.br/api/cep/v2/$cep");
        $address = json_decode($response, true);

        return $address;
    }
    public function searchForAddressCoordinates(array $address)
    {
        $street = $address['street'];
        $city = $address['city'];
        $coutry = 'Brasil';
        $address = "$street,$city,$coutry";

        $response = Http::get("https://nominatim.openstreetmap.org/search",
        ['q' => $address,
        'format' => 'json',
        'limit' => 1]);

        $lat = json_decode($response[0]['lat']);
        $lon = json_decode($response[0]['lon']);
        $coordinates = $lon . ',' . $lat;

        return $coordinates;
    }
    public function calculateShippingCostForTwoDistances(array $ceps)
    {
        foreach($ceps as $cep)
        {
            $response = $this->searchForCepAddress($cep);
            $address[] = $response;        
        }

        foreach($address as $a)
        {
            $response = $this->searchForAddressCoordinates($a);
            $coordinates[] = $response;
        }

        $coordinates = $coordinates[0] . ';' . $coordinates[1];
        $response = Http::get("http://router.project-osrm.org/route/v1/driving/{$coordinates}?overview=false");
        $distance = data_get($response->json(),'routes.0.distance', 0) / 1000;
        $pricePerKm = Auth::user()->price_per_km;
        $shipping_value = Number::currency($distance * $pricePerKm,'BRL', 'pt_BR');

        return response()->json([
            'distance' => $distance . 'km',
            'price_per_km' => $pricePerKm,
            'shipping_value' => $shipping_value
        ]);
    }
}