<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function isUserExist (string $email) {
        try {
            $user = User::query()->where('email', '=', $email)->first();

            if ($user) {
                return $user->value('id');
            }

            return $this->createUser($email);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function createUser (string $email) {
        try {
            return User::query()->create(['email' => $email, 'name' => 'random', 'password' => 'random'])->value('id');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
