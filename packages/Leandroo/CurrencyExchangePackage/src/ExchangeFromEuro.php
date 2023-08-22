<?php

namespace Leandroo\CurrencyExchangePackage;
use Exception;
use Illuminate\Support\Facades\Http;
use Leandroo\CurrencyExchangePackage\Contracts\Exchange;
use SimpleXMLElement;

class ExchangeFromEuro implements Exchange
{
    private array $validCurrencies =  ["USD",
                                    "JPY",
                                    "BGN",
                                    "CZK",
                                    "DKK",
                                    "GBP",
                                    "HUF",
                                    "PLN",
                                    "RON",
                                    "SEK",
                                    "CHF",
                                    "ISK",
                                    "NOK",
                                    "TRY",
                                    "AUD",
                                    "BRL",
                                    "CAD",
                                    "CNY",
                                    "HKD",
                                    "IDR",
                                    "ILS",
                                    "INR",
                                    "KRW",
                                    "MXN",
                                    "MYR",
                                    "NZD",
                                    "PHP",
                                    "SGD",
                                    "THB",
                                    "ZAR"];


    /**
     * @throws Exception
     */
    public function fetchCurrencyExchangeRates(string $currencyType, float $amount): \Illuminate\Http\JsonResponse
    {
        if (!$this->isValidCurrency($currencyType)) {
            return response()->json(['message'=>'invalid currency'],422);
        }

        $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json(['message'=>'error on retrieve currency values'],500);
        }

        $xml = new SimpleXMLElement($response->body());
        $result = 0;

        foreach ($xml->Cube->Cube->Cube as $currency) {
            if ((string)$currency["currency"] == strtoupper($currencyType)) {
                $exchangeRate = (float)$currency["rate"];
                $result = $this->calculateExchangeRate($exchangeRate, $amount);
                break;
            }
        }

        return response()->json(['exchangedValue'=>$result,'baseCurrency'=>'EUR','exchangeCurrency'=>$currencyType],200);
    }
    private function isValidCurrency(string $currencyCode): bool {
        return in_array(strtoupper($currencyCode), $this->validCurrencies, true);
    }

   private function calculateExchangeRate(string $rate, int $amount): float|int
   {
        return $rate * $amount;
   }


}
