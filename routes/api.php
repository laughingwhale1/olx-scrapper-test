<?php

use App\Http\Controllers\SubscriptionController;
use App\Mail\PriceChangedMail;
use App\Models\Property;
use App\Models\User;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::post('/create-subscription', [SubscriptionController::class, 'handleNewSubscription']);

