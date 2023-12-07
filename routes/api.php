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

Route::post('/send-email', function () {
//   $res = Mail::to('luckypalm95@gmail.com')->send(new PriceChangedMail('10', '20'));
});

Route::get('/users', function () {
    $users = \Illuminate\Support\Facades\DB::table('users')
        ->join('property_user', 'users.id', '=', 'property_user.user_id')
        ->where('property_user.property_id', 29)
        ->select('users.*')
        ->get();
    dd($users);
});

Route::post('/create-subscription', [SubscriptionController::class, 'handleNewSubscription']);

