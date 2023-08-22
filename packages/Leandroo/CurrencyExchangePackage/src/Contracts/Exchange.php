<?php

namespace Leandroo\CurrencyExchangePackage\Contracts;

interface Exchange
{
 function fetchCurrencyExchangeRates(string $currencyType, float $amount): \Illuminate\Http\JsonResponse;
}
