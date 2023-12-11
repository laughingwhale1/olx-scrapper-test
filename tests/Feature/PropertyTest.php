<?php

namespace Tests\Feature;

use App\Jobs\ParsePage;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testIsPropertyExistWithExistingProperty()
    {
        $url = 'https://www.olx.ua/d/uk/obyavlenie/prodam-volvo-na-hodu-IDTyGZN.html';

        $existingProperty = Property::query()->create(['url' => $url]);

        $result = (new PropertyService())->isPropertyExist($existingProperty->url);

        $this->assertEquals($existingProperty->id, $result);
    }

    public function testIsPropertyExistWithNewProperty()
    {
        // Arrange
        $url = 'https://www.olx.ua/d/uk/obyavlenie/prodam-volvo-na-hodu-IDTyGZN.html';

        // Act
        $result = (new PropertyService())->isPropertyExist($url);

        // Assert
        $this->assertDatabaseHas('properties', ['url' => $url]);
        $this->assertIsInt($result);
    }

    public function testCreateProperty()
    {
        Queue::fake();

        $url = 'https://www.olx.ua/d/uk/obyavlenie/prodam-volvo-na-hodu-IDTyGZN.html';

        $result = (new PropertyService())->createProperty($url);

        $this->assertDatabaseHas('properties', ['url' => $url]);
        Queue::assertPushed(ParsePage::class, function ($job) use ($url) {
            return $job->getUrl() === $url;
        });

        $this->assertIsInt($result);
    }
}
