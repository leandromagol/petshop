<?php

namespace Leandroo\CurrencyExchangePackage\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Leandroo\CurrencyExchangePackage\ExchangeFromEuro;

class ExchangeController
{
    public function __construct(public ExchangeFromEuro $exchange)
    {
    }

    /**
     * @throws Exception
     */
    public function getEuroExchangeValue(Request $request): JsonResponse
    {
        return $this->exchange->fetchCurrencyExchangeRates(
            $request->input('currency', ''),
            $request->input('amount', '')
        );
    }
}
