<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriaController;



Route::get('/', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| Rotas de autenticação Breeze
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Painel Administrativo
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->group(function () {


    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])
    ->name('admin.dashboard');



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