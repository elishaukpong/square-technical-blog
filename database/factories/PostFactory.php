<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->text(rand(500,1000)),
            'publication_date' => $this->faker->dateTimeBetween('-1 year', 'next week'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function imported()
    {
        return $this->state(function (array $attributes) {
            return [
                'description' => $this->faker->text(rand(500,1000)),
                'body' => ''
            ];
        });
    }
}
