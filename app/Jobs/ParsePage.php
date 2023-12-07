<?php

namespace App\Jobs;

use App\Services\PropertyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Goutte;

class ParsePage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;

    public $timeout = 120;
    public $tries = 0;

    public function __construct(
        $url
    )
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $crawler = Goutte::request('GET', $this->url);
            $priceText = $crawler->filter('h3.css-12vqlj3')->text();
            $price = preg_replace('/[^0-9]/', '', $priceText);
            Log::info("Fetched price: {$price}, on property: {$this->url}");
            if ($price) {
                $propertyService = new PropertyService();
                $propertyService->updatePropertyPrice($price, $this->url);
            }

            $this->release(3600);
        } catch (Exception $e) {
            Log::error("Error in ParsePage job: " . $e->getMessage());
            $this->release(3600);
        }
    }
}
