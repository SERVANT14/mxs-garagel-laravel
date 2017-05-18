<?php

namespace App\Mxs\Routing;

use Illuminate\Support\Facades\Route;

abstract class ServiceRouteMapper
{
    /**
     * The name of the service.
     *
     * Should match the name of the service's directory.
     *
     * @var string
     */
    protected $serviceName;

    /**
     * The relative namespace path to api related controllers.
     *
     * @var string
     */
    protected $apiControllersNamespace = 'Http\Apis';

    /**
     * The relative namespace path to web related controllers.
     *
     * @var string
     */
    protected $webControllersNamespace = 'Http\Controllers';

    /**
     * Create a new service mapper instance.
     */
    public function __construct()
    {
        $this->setServiceNameIfNotSet();
    }

    /**
     * Define the routes for the service.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Define the "web" routes for the service.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    public function mapWebRoutes()
    {
        Route::prefix(str_slug($this->serviceName))
            ->middleware('web')
            ->namespace('App\Services\\' . $this->serviceName . '\\' . $this->webControllersNamespace)
            ->group(app_path("Services/{$this->serviceName}/routes/web.php"));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api/' . str_slug($this->serviceName))
            ->middleware('api')
            ->namespace('App\Services\\' . $this->serviceName . '\\' . $this->apiControllersNamespace)
            ->group(app_path("Services/{$this->serviceName}/routes/api.php"));
    }

    /**
     * Sets the name of the service based on the class path, if none given.
     */
    protected function setServiceNameIfNotSet()
    {
        if (!$this->serviceName) {
            $this->serviceName = explode('\\', static::class)[2];
        }
    }
}