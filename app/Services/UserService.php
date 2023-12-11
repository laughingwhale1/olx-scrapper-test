<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function isUserExist (string $email) {
        try {

            $user = User::query()->where('email', $email)->first();

            if ($user) {
                return $user->id;
            }

            return $this->createUser($email);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function createUser (string $email) {
        try {
            $user = User::query()->create(['email' => $email]);
            return $user->id;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
