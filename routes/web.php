<?php



use App\Http\Controllers\AppController;

use App\Http\Controllers\Cadastros\IXC\ClienteController as IXCClienteController;

use App\Http\Controllers\Financeiro\AuthController as FnAuthController;
use App\Http\Controllers\Financeiro\AppController as FnController;
use App\Http\Controllers\Financeiro\CategoriaController as FnCategoriaController;
use App\Http\Controllers\Financeiro\ReceitasController as FnReceitasController;
use App\Http\Controllers\Financeiro\DespesasController as FnDespesasController;

use App\Http\Controllers\Financeiro\IXC\ContratoController as IXCContratoController;
use App\Http\Controllers\Financeiro\IXC\ReceitasController as IXCReceitasController;

use Illuminate\Support\Facades\Route;



Route::prefix('/')->group(function () {

    Route::get('/', [AppController::class, 'home'])->name('home');
    Route::get('/contrato', [AppController::class, 'contrato'])->name('contrato');

});



Route::prefix('/cadastros')->name('cadastros.')->group(function () {

    Route::prefix('/clientes')->group(function () {
        Route::get('/listar/{slug}', [IXCClienteController::class, 'listar']);
    });

});



Route::prefix('/financeiro')->name('financeiro.')->group(function () {


    Route::get('/auth', [FnAuthController::class, 'auth'])->name('auth');
    Route::post('/login', [FnAuthController::class, 'login'])->name('login');
    Route::post('/logout', [FnAuthController::class, 'logout'])->name('logout');


    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', [FnController::class, 'dashboard'])->name('dashboard');
        Route::get('/planilhas', [FnController::class, 'planilhas'])->name('planilhas');

        Route::prefix('/contratos')->group(function () {
            Route::get('/listar/{id_cliente}', [IXCContratoController::class, 'listar']);
            Route::get('/ativar/{id_contrato}', [IXCContratoController::class, 'ativar']);
        });

        Route::prefix('/receitas')->group(function () {
            Route::get('/', [FnController::class, 'receitas'])->name('receitas');
            Route::get('/listar/{periodo}', [FnReceitasController::class, 'listar']);
            Route::get('/ixc/baixadas/{periodo}', [IXCReceitasController::class, 'baixas']);
        });

        Route::prefix('/despesas')->group(function () {
            Route::get('/', [FnController::class, 'despesas'])->name('despesas');
            Route::get('/listar/{periodo}', [FnDespesasController::class, 'listar']);
        });

        Route::prefix('/categorias')->group(function () {

            Route::get('/mostrar/{categoria}', [FnCategoriaController::class, 'mostrar']);
            Route::get('/mostrar/{categoria}/subcategoria/{subcategoria}', [FnCategoriaController::class, 'subcategoria']);

            Route::get('/listar/{filters?}', [FnCategoriaController::class, 'listar']);
            Route::post('/criar', [FnCategoriaController::class, 'criar']);
            Route::put('/editar', [FnCategoriaController::class, 'editar']);
            Route::delete('/remover', [FnCategoriaController::class, 'remover']);

        });

    });


});
