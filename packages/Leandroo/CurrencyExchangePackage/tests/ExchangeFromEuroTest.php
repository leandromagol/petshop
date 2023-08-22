<?php

namespace Leandroo\CurrencyExchangePackage\tests;

use Illuminate\Support\Facades\Http;
use Leandroo\CurrencyExchangePackage\ExchangeFromEuro;
use Tests\TestCase;

class ExchangeFromEuroTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testFetchCurrencyExchangeRatesSuccess()
    {
        Http::fake([
            'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml' => Http::response($this->getSampleXmlResponse(), 200)
        ]);

        $exchange = new ExchangeFromEuro();
        $response = $exchange->fetchCurrencyExchangeRates('USD', 10);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode([
            'exchangedValue' => 10 * 1.0887,
            'baseCurrency' => 'EUR',
            'exchangeCurrency' => 'USD'
        ]));
    }

    /**
     * @throws \Exception
     */
    public function testFetchCurrencyExchangeRatesInvalidCurrency()
    {
        $exchange = new ExchangeFromEuro();
        $response = $exchange->fetchCurrencyExchangeRates('INVALID', 10);


        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode([
            'message' => 'invalid currency'
        ]));
    }

    /**
     * @throws \Exception
     */
    public function testFetchCurrencyExchangeRatesServerError()
    {
        Http::fake([
            'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml' => Http::response([], 500)
        ]);

        $exchange = new ExchangeFromEuro();
        $response = $exchange->fetchCurrencyExchangeRates('USD', 10);
        $this->assertEquals(500, $response->getStatusCode());

        $this->assertJson($response->getContent(),json_encode([
            'message' => 'error on retrieve currency values'
        ]));
    }

    private function getSampleXmlResponse(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
        <gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
            <gesmes:subject>Reference rates</gesmes:subject>
            <gesmes:Sender>
                <gesmes:name>European Central Bank</gesmes:name>
            </gesmes:Sender>
            <Cube>
                <Cube time="2023-08-22">
                    <Cube currency="USD" rate="1.0887"/>
                    <Cube currency="JPY" rate="158.70"/>
                </Cube>
            </Cube>
        </gesmes:Envelope>';
    }
}
