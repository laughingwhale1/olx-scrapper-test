<?php

use App\Http\Controllers\SubscriptionController;
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

Route::get('/page', function () {
    $crawler = Goutte::request('GET', 'https://www.olx.ua/d/uk/obyavlenie/kolyaska-geoby-IDT60zC.html');
    $priceText = $crawler->filter('h3.css-12vqlj3')->text();
    $price = preg_replace('/[^0-9]/', '', $priceText);

    return $price;
});

Route::post('/create-subscription', [SubscriptionController::class, 'handleNewSubscription']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
