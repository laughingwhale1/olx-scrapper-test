<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function isSubscriptionExists (int $userId, int $propertyId) {
        $exists = DB::table('property_user')
            ->where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->exists();

        if ($exists) {
            dd('exists', $exists);
        } else {
            /** @var User $user */
            $user = User::query()->find($userId);
            $user->properties()->attach($propertyId);
            dd('not exists, created', $exists);
        }
    }
}
