<?php

namespace TremulantTech\LaravelEbayApi;

use Illuminate\Support\ServiceProvider;
use TremulantTech\LaravelEbayApi\EbayApi;

class EbayApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->registerIndividualApis();

        $this->app->singleton(EbayApi::class, function () {
            return new EbayApi(config('ebay-api'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/ebay-api.php' => config_path('ebay-api.php'),
        ], 'config');

        $time = time();

        $sellerTable = database_path('migrations/' . date('Y_m_d_his', $time) . '_create_ebay_api_sellers_table.php');

        $credentialsTable = database_path('migrations/' . date('Y_m_d_his', $time + 1) . '_create_ebay_api_credentials_table.php');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_ebay_api_sellers_table.php' => $sellerTable,
            __DIR__ . '/../database/migrations/create_ebay_api_credentials_table.php' => $credentialsTable,
        ], 'migrations');
    }

    private function registerIndividualApis()
    {
        foreach (EbayApi::API_CLASSES as $cls) {
            $definitions = $cls::getConfigDefinitions();

            $placeholder = array_fill_keys(array_keys($definitions), null);

            foreach ($definitions as $key => $def) {
                if ($key === 'credentials') {
                    $placeholder[$key] = config('ebay-api.sandbox.credentials', []);
                }

                if ($key === 'authorization') {
                    $placeholder[$key] = config('ebay-api.sandbox.oauthUserToken', '');
                }

                //will use the default value automatically
                if (isset($def['default'])) {
                    unset($placeholder[$key]);
                }
            }

            $this->app->bind($cls, fn () => new $cls($placeholder));
        }
    }
}
