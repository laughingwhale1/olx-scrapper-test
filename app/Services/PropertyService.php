<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function isPropertyExist (string $url) {
        try {
            $property = Property::query()->where('url', $url)->first();

            if ($property) {
                return $property->value('id');
            }

            return $this->createProperty($url);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function createProperty (string $url) {
        try {

            return Property::query()->create(['url' => $url])->value('id');


        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
