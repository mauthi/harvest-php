<?php
namespace Harvest\Laravel\Five;

use Illuminate\Support\ServiceProvider;
use Harvest\Harvest;

/**
 * Class HarvestServiceProvider
 *
 * @namespace    Harvest\Laravel\Five
 * @author     Joridos <joridoss@gmail.com>
 */
class HarvestServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $options = $this->app['config']['services.harvest'];

        $this->app->singleton(Harvest::class, function($app) use ($options)
        {
            $harvest = $app['config']['services.harvest'];
            return new Harvest($harvest['account_id'], $harvest['token'], $fastbill['debug']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Harvest::class];
    }

}
