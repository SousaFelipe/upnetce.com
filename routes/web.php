<?php
use Illuminate\Support\Facades\Route;



Route::prefix('/')->group(function () {

    Route::get('/', [App\Http\Controllers\AppController::class, 'home'])->name('home');
    Route::get('/contrato', [App\Http\Controllers\AppController::class, 'contrato'])->name('contrato');

});
