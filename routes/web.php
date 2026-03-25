<?php

use App\Http\Repositories\ShippingRepository;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ceps =
    ['08280180',
    '08280000'];

    $s = app(ShippingRepository::class);
    return $s->searchForCepAddress($ceps);
});
