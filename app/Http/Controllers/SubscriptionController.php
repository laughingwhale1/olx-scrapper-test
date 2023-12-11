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
        private SubscriptionService $subscriptionService,
    )
    {
    }

    public function handleNewSubscription (SubscriptionRequest $subscriptionRequest) {
        return $this->subscriptionService->handleNewSubscription($subscriptionRequest->validated());
    }
}
