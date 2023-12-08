<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    public function rules (): array {
        return [
            'email' => 'required|email',
            'url' => 'required|string|url:https',
        ];
    }
}
