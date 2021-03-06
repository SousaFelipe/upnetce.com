<?php



use App\Http\Controllers\AppController;

use App\Http\Controllers\Cadastros\AppController as CdAppConrtoller;
use App\Http\Controllers\Cadastros\FornecedorController as CdFornecedorController;

use App\Http\Controllers\Cadastros\IXC\ClienteController as IXCClienteController;

use App\Http\Controllers\Suporte\IXC\OsController as IXCOsController;

use App\Http\Controllers\Financeiro\AuthController as FnAuthController;
use App\Http\Controllers\Financeiro\AppController as FnController;
use App\Http\Controllers\Financeiro\CategoriaController as FnCategoriaController;
use App\Http\Controllers\Financeiro\ContaController as FnContaController;
use App\Http\Controllers\Financeiro\ReceitasController as FnReceitasController;
use App\Http\Controllers\Financeiro\DespesasController as FnDespesasController;

use App\Http\Controllers\Financeiro\IXC\ContratoController as IXCContratoController;
use App\Http\Controllers\Financeiro\IXC\ReceitasController as IXCReceitasController;
use App\Http\Controllers\Financeiro\IXC\DespesasController as IXCDespesasController;

use Illuminate\Support\Facades\Route;



Route::prefix('/')->group(function () {

    Route::get('/', [AppController::class, 'home'])->name('home');
    Route::get('/contrato', [AppController::class, 'contrato'])->name('contrato');

});



Route::prefix('/cadastros')->middleware('auth')->name('cadastros.')->group(function () {

    Route::prefix('/clientes')->group(function () {
        Route::get('/listar/{slug?}', [IXCClienteController::class, 'listar']);
    });

    Route::prefix('/fornecedores')->group(function () {
        Route::get('/', [CdAppConrtoller::class, 'fornecedores'])->name('fornecedores');
        Route::get('/listar', [CdFornecedorController::class, 'listar']);
        Route::post('/criar', [CdFornecedorController::class, 'criar']);
        Route::put('/editar', [CdFornecedorController::class, 'editar']);
        Route::put('/sync', [CdFornecedorController::class, 'sync']);
        Route::delete('/remover', [CdFornecedorController::class, 'remover']);
    });

});



Route::prefix('/suporte')->name('suporte.')->group(function () {

    Route::prefix('/oss')->group(function () {
        Route::get('/listar/{id_cliente}', [IXCOsController::class, 'listar']);
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
            Route::get('/listar', [FnReceitasController::class, 'listar']);
        });

        Route::prefix('/despesas')->group(function () {
            Route::get('/', [FnController::class, 'despesas'])->name('despesas');
            Route::get('/listar', [FnDespesasController::class, 'listar']);
            Route::post('/criar', [FnDespesasController::class, 'criar']);
        });

        Route::prefix('/categorias')->group(function () {

            Route::get('/mostrar/{categoria}', [FnCategoriaController::class, 'mostrar']);
            Route::get('/mostrar/{categoria}/subcategoria/{subcategoria}', [FnCategoriaController::class, 'subcategoria']);

            Route::get('/listar/{filters?}', [FnCategoriaController::class, 'listar']);
            Route::post('/criar', [FnCategoriaController::class, 'criar']);
            Route::put('/editar', [FnCategoriaController::class, 'editar']);
            Route::delete('/remover', [FnCategoriaController::class, 'remover']);

        });

        Route::prefix('/contas')->group(function () {

            Route::get('/listar/{filters?}', [FnContaController::class, 'listar']);

        });

    });


});
