<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    public function isSubscriptionExists (int $userId, int $propertyId) {
        $exists = DB::table('property_user')
            ->where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->exists();

        if ($exists) {
            Log::info('exists');
            return response(['message' => 'subscription already exists'], 400);
        } else {
            /** @var User $user */
            $user = User::query()->find($userId);
            $user->properties()->attach($propertyId);
            Log::info('not exists, created');
            return response(['message' => 'subscription created'], 201);
        }
    }
}
