<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'thumbnail' => $this->faker->imageUrl(),
            'category' => $this->faker->randomElement(['Marketing', 'Tecnologia', 'Design']),
            'views' => $this->faker->numberBetween(0, 1000),
            'likes' => $this->faker->numberBetween(0, 500),
        ];
    }
}