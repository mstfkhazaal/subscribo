<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});
Route::domain(config("filament.domain"))
    ->middleware(config("filament.middleware.base"))
    ->name(config('filament-jet.route_group_prefix'))
    ->prefix(config("filament.path"))
    ->group(function () {
        // Personal data export...
        if (\Mstfkhazaal\FilamentJet\Features::canExportPersonalData()) {
            Route::personalDataExports('personal-data-exports');
        }
    });
