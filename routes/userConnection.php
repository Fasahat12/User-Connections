<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\SentRequestController;
use App\Http\Controllers\ReceivedRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('sent_requests/{id}/{offset}',[SentRequestController::class, 'index']);
Route::post('sent_requests',[SentRequestController::class, 'store']);
Route::delete('sent_requests/{id}',[SentRequestController::class, 'destroy']);

Route::get('received_requests/{id}/{offset}',[ReceivedRequestController::class, 'index']);


Route::get('suggestions/{id}/{offset}',[SuggestionController::class, 'index']);
