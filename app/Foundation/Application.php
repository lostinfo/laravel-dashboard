<?php


namespace App\Foundation;


use App\Providers\RoutingServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Log\LogServiceProvider;


class Application extends \Illuminate\Foundation\Application
{
    public function __construct($basePath = null)
    {
        parent::__construct($basePath);
    }

    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
        $this->register(new LogServiceProvider($this));
        $this->register(new RoutingServiceProvider($this));
    }
}