<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Larabase\NovaPage\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/', [PageController::class, 'get'])->name('nova-page.get');
Route::post('/', [PageController::class, 'post'])->name('nova-page.post');
