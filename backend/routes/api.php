<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\ProdutoImagemController;
use App\Http\Controllers\Api\DashboardController;


/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::post('/login', [
    AuthController::class,
    'login'
]);



/*
|--------------------------------------------------------------------------
| Rotas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Autenticação
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);



    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ]);



    /*
    |--------------------------------------------------------------------------
    | Categorias
    |--------------------------------------------------------------------------
    */

    Route::apiResource(
        'categorias',
        CategoriaController::class
    );



    /*
    |--------------------------------------------------------------------------
    | Produtos
    |--------------------------------------------------------------------------
    */

    Route::apiResource(
        'produtos',
        ProdutoController::class
    );



    /*
    |--------------------------------------------------------------------------
    | Imagens dos produtos
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/produtos/{produto}/imagem',
        [
            ProdutoImagemController::class,
            'store'
        ]
    );


    Route::delete(
        '/imagem/{imagem}',
        [
            ProdutoImagemController::class,
            'destroy'
        ]
    );


});