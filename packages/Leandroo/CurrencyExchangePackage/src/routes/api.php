<?php

use Illuminate\Support\Facades\Route;
use Leandroo\CurrencyExchangePackage\Controllers\ExchangeController;

Route::get('euro/exchange', [ExchangeController::class,'getEuroExchangeValue']);
