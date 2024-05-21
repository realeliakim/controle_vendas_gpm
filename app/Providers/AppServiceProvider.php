<?php

namespace App\Providers;

use App\Helpers\CollectionHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set the default response for API
        Response::macro('apiResponse', function ($data, string $message = null, int $code = 200) {
            return Response::json([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ], $code);
        });

        // Set the default response for API exceptions
        Response::macro('apiException', function (string|array $error, int $code = 400) {
            return Response::json([
                'status' => false,
                'error' => $error
            ], ($code > 500 || $code < 200) ? 500 : $code);
        });


        Collection::macro('paginate', function (int $perPage = 5, string $message = null) {
            $paginator = CollectionHelper::paginate($this, $perPage)->toArray();
            $paginator['status'] = true;
            $paginator['message'] = '';
            return  $paginator;
        });
    }
}
