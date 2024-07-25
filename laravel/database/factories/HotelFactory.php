<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Hotel::class;
    public function definition(): array
    {
        return [
            'Hotel Name' => $this->faker->company,
            'Country' => $this->faker->countryCode,
            'City' => $this->faker->city,
            'Price' => $this->faker->randomFloat(2, 50, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Hotel $hotel) {
            // Create facilities and attach to hotel
            $facilities = Facility::factory()->count(rand(1, 5))->create();
            $hotel->facilities()->sync($facilities->pluck('id')->toArray());
        });
    }
}
