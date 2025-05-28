<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Availability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'date_available' => $this->faker->dateTimeBetween('+0 days', '+30 days')->format('Y-m-d'),
        ];
    }
}
