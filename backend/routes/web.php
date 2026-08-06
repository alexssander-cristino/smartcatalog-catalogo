<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriaController;



Route::get('/', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| Rotas de autenticação
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Painel Administrativo
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');



        /*
        |--------------------------------------------------------------------------
        | Categorias
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'categorias',
            CategoriaController::class
        );

});