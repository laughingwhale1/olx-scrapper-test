<?php

namespace App\Jobs;

use App\Mail\PriceChangedMail;
use App\Services\PropertyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class PriceChangeEmailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 0;
    protected $email;
    protected $price;

    public function __construct(string $email, string $price)
    {
        $this->email = $email;
        $this->price = $price;
    }

    public function handle(): void
    {

        try {
            $res = Mail::to($this->email)->send(new PriceChangedMail($this->price));

            if ($res) {
                Log::info("Email to: {$this->email} sent");
            }
        } catch (Exception $e) {
            Log::error("Error in PriceChangeEmailSend job: " . $e->getMessage());
        }
    }
}
