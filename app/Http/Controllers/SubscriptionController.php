<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Services\PropertyService;
use App\Services\SubscriptionService;
use App\Services\UserService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        private UserService $userService,
        private PropertyService $propertyService,
        private SubscriptionService $subscriptionService,
    )
    {
    }

    public function handleNewSubscription (SubscriptionRequest $subscriptionRequest) {

        $userId = $this->userService->isUserExist($subscriptionRequest->validated()['email']);
        $propertyId = $this->propertyService->isPropertyExist($subscriptionRequest->validated()['url']);

        $this->subscriptionService->isSubscriptionExists($userId, $propertyId);
    }
}
