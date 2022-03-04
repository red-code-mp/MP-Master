<?php


namespace MP\Base;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->macros();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * register all macros
     * @author Amr
     */
    function macros()
    {
        $this->__responseMacro();
        $this->__routeMacro();
    }

    /**
     * Add macro function to Response class
     * @author Amr
     */
    function __responseMacro()
    {
        /**
         * this is the unified Vue's response
         *
         * @author Amr
         */
        Response::macro('vue', function ($status, $message = '', $payload = []) {
            return Response::json([
                'status' => $status >= 200 && $status < 400,
                'message' => $message,
                'lang' => app()->getLocale(),
                'payload' => $payload,
            ])->header('Content-Type', 'application/json')
                ->setStatusCode($status, $message);
        });
    }

    /**
     * Add macro function to Route class
     * @author Amr
     */
    function __routeMacro()
    {
        Route::macro('operations', function ($name, $controller, $callback = null, $options = []) {
            $options['prefix'] = $name;
            Route::group($options, function () use ($controller, $callback) {
                Route::get('/antecedents', $controller . '@antecedents');
                Route::post('/', $controller . '@store');
                Route::match(['POST', 'PUT', 'PATCH'], '/{id}', $controller . '@update')->name('resource.update')->where('id', '[0-9]+');
                Route::get('/', $controller . '@index');
                Route::get('/{id}', $controller . '@show')->where('id', '[0-9]+');
                Route::delete('/{id}', $controller . '@delete')->where('id', '[0-9]+');
                Route::match(['POST', 'PUT', 'PATCH'], '/{id}/change_active', $controller . '@changeActive')->where('id', '[0-9]+');
                if ($callback)
                    $callback();
            });


        });
    }
}
