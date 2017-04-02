<?php 

namespace Morisuke\SearchList\Providers;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'search');
        $this->publishes([__DIR__ . '/../../config/search.php' => config_path('search.php')], 'search');
    }
}
