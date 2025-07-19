<?php

use App\Http\Middleware\PreventXss;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{Exceptions, Middleware};
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/admin')
                ->name('adminsApi.')
                ->group(base_path('routes/adminsApi.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(PreventXss::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // $exceptions->render(function (NotFoundHttpException $e, $request) {
        //     $model = class_basename($e->getModel());

        //     return response()->json(['msg' => 'not found'], 404);
        // });

    })->create();
