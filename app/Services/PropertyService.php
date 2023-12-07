<?php

namespace App\Services;

use App\Jobs\ParsePage;
use App\Models\Property;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PropertyService
{

    public function __construct(private EmailService $emailService)
    {
    }

    public function isPropertyExist (string $url) {
        try {
            $property = Property::query()->where('url', $url)->first();

            if ($property) {
                return $property->id;
            }

            return $this->createProperty($url);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function createProperty (string $url) {
        try {
            $property = Property::query()->create(['url' => $url]);

            if ($property) {
//                ParsePage::dispatch($url);
                dispatch(new ParsePage($url));
                return $property->id;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updatePropertyPrice (string $fetchedPrice, string $url) {

        if (Cache::has($url)) {

            $cachedPrice = Cache::get($url);

            if ($cachedPrice !== $fetchedPrice) {
                $property = Property::query()->where('url', $url)->first();
                $property->update(['price' => $fetchedPrice]);
                $property->save();
                Cache::put($url, $fetchedPrice, $seconds = 7200);
                $this->emailService->sendEmails($property->id, $property->price);
            }
            return;
        }

        $property = Property::query()->where('url', $url)->first();

        if ($property->price !== $fetchedPrice) {
            Cache::put($url, $fetchedPrice, $seconds = 36000);
            $property->update(['price' => $fetchedPrice]);
            $property->save();
            if (!is_null($property->price)) {
                $this->emailService->sendEmails($property->id, $property->price);
            }
        }
    }


}
