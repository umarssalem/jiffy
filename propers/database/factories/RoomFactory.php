<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(), // ✅ This creates a property for this room
            'max' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}