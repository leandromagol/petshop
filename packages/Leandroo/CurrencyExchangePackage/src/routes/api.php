<?php
use Leandroo\CurrencyExchangePackage\Controllers\ExchangeController;
use Illuminate\Support\Facades\Route;

Route::get('exchange',[ExchangeController::class,'getEuroExchangeValue']);
