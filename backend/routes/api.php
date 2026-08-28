<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\ProdutoImagemController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\EstoqueController;


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
| LOGIN
|--------------------------------------------------------------------------
|
| POST /api/login
|
*/

Route::post('/login', [
    AuthController::class,
    'login',
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
    | USUÁRIO
    |--------------------------------------------------------------------------
    */

    /*
    | GET /api/user
    |
    | Retorna os dados do usuário autenticado.
    */

    Route::get('/user', [
        AuthController::class,
        'user',
    ])->name('api.user');


    /*
    | PUT /api/user
    |
    | Atualiza nome, e-mail e senha.
    */

    Route::put('/user', [
        AuthController::class,
        'updateProfile',
    ])->name('api.user.update');


    /*
    | POST /api/logout
    |
    | Encerra a sessão/token atual.
    */

    Route::post('/logout', [
        AuthController::class,
        'logout',
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
        'index',
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
    | PEDIDOS
    |--------------------------------------------------------------------------
    |
    | GET    /api/pedidos
    | GET    /api/pedidos/{pedido}
    |
    */

    Route::apiResource(
        'pedidos',
        PedidoController::class
    )->only([
        'index',
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | IMAGENS DOS PRODUTOS
    |--------------------------------------------------------------------------
    */


    /*
    | POST /api/produtos/{produto}/imagem
    |
    | Envia uma imagem para determinado produto.
    */

    Route::post(
        '/produtos/{produto}/imagem',
        [
            ProdutoImagemController::class,
            'store',
        ]
    )->name('api.produtos.imagem.store');


    /*
    | DELETE /api/imagem/{imagem}
    |
    | Exclui uma imagem do produto.
    */

    Route::delete(
        '/imagem/{imagem}',
        [
            ProdutoImagemController::class,
            'destroy',
        ]
    )->name('api.produtos.imagem.destroy');

    /*
|--------------------------------------------------------------------------
| ESTOQUE
|--------------------------------------------------------------------------
*/

Route::get('/estoque', [
    EstoqueController::class,
    'index',
])->name('api.estoque.index');


Route::get('/estoque/{produto}', [
    EstoqueController::class,
    'show',
])->name('api.estoque.show');


Route::post('/estoque/{produto}/entrada', [
    EstoqueController::class,
    'entrada',
])->name('api.estoque.entrada');


Route::post('/estoque/{produto}/saida', [
    EstoqueController::class,
    'saida',
])->name('api.estoque.saida');


Route::put('/estoque/{produto}/ajustar', [
    EstoqueController::class,
    'ajustar',
])->name('api.estoque.ajustar');

});