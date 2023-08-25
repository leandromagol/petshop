<?php
namespace Leandroo\CurrencyExchangePackage\Support;

use Illuminate\Support\ServiceProvider;

class CurrencyExchangeProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

    }
}
