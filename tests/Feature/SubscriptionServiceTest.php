<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use App\Services\PropertyService;
use App\Services\SubscriptionService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SubscriptionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testHandleNewSubscription()
    {
        // Arrange: Create real User and Property instances
        $url = 'https://www.olx.ua/d/uk/obyavlenie/prodam-volvo-na-hodu-IDTyGZN.html';
        $user = User::query()->create(['email' => 'test@example.com']);
        $property = Property::query()->create(['url' => $url]);

        // Create an instance of the SubscriptionService with real dependencies
        $userService = new UserService(); // Assuming UserService can be instantiated without any arguments
        $propertyService = new PropertyService(); // Assuming PropertyService can be instantiated without any arguments
        $service = new SubscriptionService($userService, $propertyService);

        // Act
        $response = $service->handleNewSubscription(['email' => 'test@example.com', 'url' => $url]);

        // Assert
        $this->assertInstanceOf(Response::class, $response);
        // Add additional assertions here to validate the response content or status code

        // Clean up: Detach the property from the user to maintain test isolation
        $user->properties()->detach($property->id);
    }

    public function testIsSubscriptionExists()
    {
        $url = 'https://www.olx.ua/d/uk/obyavlenie/prodam-volvo-na-hodu-IDTyGZN.html';

        $user = User::query()->create([
            'email' => 'test@example.com',
        ]);
        $property = Property::query()->create(['url' => $url]);

        $user->properties()->attach($property->id);

        $service = new SubscriptionService(new UserService(), new PropertyService());

        $response = $service->isSubscriptionExists($user->id, $property->id);
        $responseData = json_decode($response->content(), true);

        // Assert
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('subscription already exists', $responseData['message']);

    }
}
