<?php

namespace MP\Base;

use App\Exceptions\Handler;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MasterPackageServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'MP\Base\Http\Controllers';
    /**
     * list of package's helpers
     * @author Amr
     * @var array
     */
    protected $helpers = [
        'Constants',
        'Methods'
    ];

    public function boot()
    {
        parent::boot();
        // public package's configurations
        $this->publishes([
            __DIR__ . '/../config/MasterPackageConfig.php' => config_path('MasterPackageConfig.php'),
        ]);
        // load package's translation files
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'MP');
    }


    public function register()
    {
        $this->app->register(MacroServiceProvider::class);
        $this->registerHelpers();
    }

    /**
     * register package's helpers
     * @author Amr
     */
    function registerHelpers()
    {
        foreach ($this->helpers as $helper) {
            $helper_path = __DIR__ . '/Helpers/' . $helper . '.php';
            if (File::isFile($helper_path)) {
                require_once $helper_path;
            }
        }
    }

    public function provides()
    {
        return [\MP\Base\MacroServiceProvider::class];
    }

}
