<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/basic-form' , [FormController::class , 'basicForm']);
Route::post('/contact-form' , [FormController::class , 'contactForm']);
Route::post('/order-form' , [FormController::class , 'orderForm']);

Route::get('/cities', [LocationController::class, 'getCities']);
Route::get('/districts/{cityId}', [LocationController::class, 'getDistrictsByCity']);
