<?php

namespace Travelience\GraphQL;

use Illuminate\Support\ServiceProvider;
use Route;

class GraphQLServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('graphql-client.php'),
        ]);        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
