<?php
use Leandroo\CurrencyExchangePackage\Controllers\ExchangeController;
use Illuminate\Support\Facades\Route;

Route::get('euro/exchange',[ExchangeController::class,'getEuroExchangeValue']);
