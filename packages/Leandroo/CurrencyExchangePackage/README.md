# Laravel Package: Package to exchange a euro value to the provided currency
## Usage
This Laravel package provides an easy way to exchange values from euro to a provided currency. 
It exposes a get route euro/exchange. that receives query params named currency, amount example
```bash
http://myapi/euro/exchange?amount=100&currency=BRL
```
You wil recieve a json response like that
```bash
{
	"exchangedValue": 528.65,
	"baseCurrency": "EUR",
	"exchangeCurrency": "BRL"
}
```

The list of available currencies to exchange is 
```bash 
["USD",
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
```
