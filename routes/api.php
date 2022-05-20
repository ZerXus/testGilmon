<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|----------------- ---------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('document', [DocumentController::class, 'create']);
Route::get('document/{document}', [DocumentController::class, 'get']);
Route::patch('document/{document}', [DocumentController::class, 'edit']);
Route::post('document/{document}/publish', [DocumentController::class, 'publish']);
Route::get('document', [DocumentController::class, 'getList']);
