<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testIsUserExistWithExistingUser()
    {
        $existingUser = User::query()->create([
            'email' => 'test@example.com',
        ]);

        $result = (new UserService())->isUserExist($existingUser->email);

        $this->assertEquals($existingUser->id, $result);
    }

    public function testIsUserExistWithNewUser()
    {

        $email = 'newuser@example.com';


        $result = (new UserService())->isUserExist($email);


        $this->assertDatabaseHas('users', ['email' => $email]);
        $this->assertIsInt($result);
    }

    public function testCreateUser()
    {
        $email = 'newuser@example.com';

        $result = (new UserService())->createUser($email);

        $this->assertDatabaseHas('users', ['email' => $email]);
        $this->assertIsInt($result);
    }

}
