<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\ProdutoImagemController;
use App\Http\Controllers\Api\DashboardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Todas as rotas deste arquivo recebem automaticamente o prefixo /api.
|
*/


/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
|
| POST /api/login
|
*/

Route::post('/login', [
    AuthController::class,
    'login'
])->name('api.login');


/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS
|--------------------------------------------------------------------------
|
| Todas as rotas abaixo precisam de um token Sanctum válido.
|
*/

Route::middleware('auth:sanctum')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | USUÁRIO AUTENTICADO
    |--------------------------------------------------------------------------
    |
    | GET /api/user
    |
    */

    Route::get('/user', [
        AuthController::class,
        'user'
    ])->name('api.user');


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    |
    | POST /api/logout
    |
    */

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('api.logout');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    |
    | GET /api/dashboard
    |
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('api.dashboard');


    /*
    |--------------------------------------------------------------------------
    | CATEGORIAS
    |--------------------------------------------------------------------------
    |
    | GET    /api/categorias
    | POST   /api/categorias
    | GET    /api/categorias/{categoria}
    | PUT    /api/categorias/{categoria}
    | PATCH  /api/categorias/{categoria}
    | DELETE /api/categorias/{categoria}
    |
    */

    Route::apiResource(
        'categorias',
        CategoriaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | PRODUTOS
    |--------------------------------------------------------------------------
    |
    | GET    /api/produtos
    | POST   /api/produtos
    | GET    /api/produtos/{produto}
    | PUT    /api/produtos/{produto}
    | PATCH  /api/produtos/{produto}
    | DELETE /api/produtos/{produto}
    |
    */

    Route::apiResource(
        'produtos',
        ProdutoController::class
    );


    /*
    |--------------------------------------------------------------------------
    | IMAGENS DOS PRODUTOS
    |--------------------------------------------------------------------------
    |
    | POST /api/produtos/{produto}/imagem
    |
    */

    Route::post(
        '/produtos/{produto}/imagem',
        [
            ProdutoImagemController::class,
            'store'
        ]
    )->name('api.produtos.imagem.store');


    /*
    |--------------------------------------------------------------------------
    | EXCLUIR IMAGEM
    |--------------------------------------------------------------------------
    |
    | DELETE /api/imagem/{imagem}
    |
    */

    Route::delete(
        '/imagem/{imagem}',
        [
            ProdutoImagemController::class,
            'destroy'
        ]
    )->name('api.produtos.imagem.destroy');


});

