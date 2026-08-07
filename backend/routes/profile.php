<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;



Route::middleware('auth')->group(function () {



    /*
    |--------------------------------------------------------------------------
    | Editar perfil
    |--------------------------------------------------------------------------
    */


    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])
    ->name('profile.edit');





    /*
    |--------------------------------------------------------------------------
    | Atualizar perfil
    |--------------------------------------------------------------------------
    */


    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])
    ->name('profile.update');







    /*
    |--------------------------------------------------------------------------
    | Atualizar senha
    |--------------------------------------------------------------------------
    */


    Route::put('/password', [
        ProfileController::class,
        'updatePassword'
    ])
    ->name('password.update');







    /*
    |--------------------------------------------------------------------------
    | Excluir conta
    |--------------------------------------------------------------------------
    */


    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])
    ->name('profile.destroy');


});