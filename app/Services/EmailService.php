<?php

namespace App\Services;

use App\Jobs\PriceChangeEmailSend;

class EmailService
{
    public function sendEmails (int $propertyId, string $price) {
        $users = \Illuminate\Support\Facades\DB::table('users')
            ->join('property_user', 'users.id', '=', 'property_user.user_id')
            ->where('property_user.property_id', $propertyId)
            ->select('users.*')
            ->get();
        foreach ($users as $user) {
            dispatch(new PriceChangeEmailSend($user->email, $price));
        }
    }
}
