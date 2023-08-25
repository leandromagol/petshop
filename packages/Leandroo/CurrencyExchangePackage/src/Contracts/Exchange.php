<?php

namespace Leandroo\CurrencyExchangePackage\Contracts;

interface Exchange
{
    public function fetchCurrencyExchangeRates(string $currencyType, float $amount): \Illuminate\Http\JsonResponse;
}
