<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Admin\ProdutoImagemController;
use App\Http\Controllers\Admin\EstoqueController;
use App\Http\Controllers\Admin\PedidoController;

use App\Http\Controllers\CatalogoController;


/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()
        ->route('catalogo.index');

});


/*
|--------------------------------------------------------------------------
| Autenticação Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Catálogo Público
|--------------------------------------------------------------------------
*/

Route::get('/catalogo', [
    CatalogoController::class,
    'index'
])
    ->name('catalogo.index');


Route::get('/produto/{produto}', [
    CatalogoController::class,
    'produto'
])
    ->name('catalogo.produto');


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

        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Categorias
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'categorias',
            CategoriaController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Produtos
        |--------------------------------------------------------------------------
        */

        Route::resource(
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
        )
            ->name('produtos.imagem.store');


        Route::delete(
            '/imagem/{imagem}',
            [
                ProdutoImagemController::class,
                'destroy'
            ]
        )
            ->name('produtos.imagem.destroy');


        /*
        |--------------------------------------------------------------------------
        | Controle de Estoque
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/estoque',
            [
                EstoqueController::class,
                'index'
            ]
        )
            ->name('estoque.index');


        /*
        |--------------------------------------------------------------------------
        | Formulário de movimentação de estoque
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/estoque/{produto}/movimentar',
            [
                EstoqueController::class,
                'create'
            ]
        )
            ->name('estoque.create');


        /*
        |--------------------------------------------------------------------------
        | Registrar movimentação de estoque
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/estoque/{produto}',
            [
                EstoqueController::class,
                'store'
            ]
        )
            ->name('estoque.store');


        /*
        |--------------------------------------------------------------------------
        | Histórico de estoque
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/estoque/{produto}/historico',
            [
                EstoqueController::class,
                'historico'
            ]
        )
            ->name('estoque.historico');


        /*
        |--------------------------------------------------------------------------
        | Pedidos
        |--------------------------------------------------------------------------
        |
        | Os pedidos são internos.
        | Não existe venda online nesta etapa.
        |
        */

        Route::resource(
            'pedidos',
            PedidoController::class
        );


    });