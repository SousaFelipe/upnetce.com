<?php


use App\Http\Controllers\API\ClearMAC\ClienteController as ClienteClearMAC;
use App\Http\Controllers\API\ClearMAC\ContratoController;
use App\Http\Controllers\API\ClearMAC\RadUsuariosController;

use App\Http\Controllers\Darth\AuthController;
use App\Http\Controllers\Darth\Cadastros\ClienteController as ClienteCadastro;
use App\Http\Controllers\Darth\Cadastros\ClienteContratoController as ClienteContratoCadastro;

use Illuminate\Support\Facades\Route;



Route::get('/csrf', [App\Http\Controllers\Controller::class, 'csrf']);



Route::prefix('/clearmac')->namespace('App\\Http\\Controllers\\API\\ClearMAC')->group(function () {


    Route::prefix('/clientes')->group(function () {
        Route::get('/find/{slug}', [ClienteClearMAC::class, 'listar']);
        Route::get('/listar/{slug}', [ClienteClearMAC::class, 'listar']);
    });


    Route::prefix('/contratos')->group(function () {
        Route::get('/listar/{id_cliente}', [ContratoController::class, 'listar']);
        Route::get('/ativar/{id_contrato}', [ContratoController::class, 'ativar']);
    });


    Route::prefix('/provedor')->group(function () {
        Route::get('/logins/find/{id_cliente}', [RadUsuariosController::class, 'find']);
        Route::get('/logins/clear/{id_login}', [RadUsuariosController::class, 'clear']);
    });


});



Route::prefix('/darth')->namespace('App\\Http\\Controllers\\Darth')->group(function () {


    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::prefix('/cadastros')->middleware('auth.token')->group(function () {

        Route::get('/clientes/listar', [ClienteCadastro::class, 'listar']);
        Route::post('/clientes/criar', [ClienteCadastro::class, 'criar']);
        Route::put('/clientes/editar', [ClienteCadastro::class, 'editar']);
        Route::delete('/clientes/remover', [ClienteCadastro::class, 'remover']);

        Route::get('/contratos/listar', [ClienteContratoCadastro::class, 'listar']);
        Route::post('/contratos/criar', [ClienteContratoCadastro::class, 'criar']);
        Route::put('/contratos/editar', [ClienteContratoCadastro::class, 'editar']);
        Route::delete('/contratos/remover', [ClienteContratoCadastro::class, 'remover']);

    });

});
