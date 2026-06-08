<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->randomElement([
                'Vendedor de confianza, el libro estaba impecable.',
                'Todo perfecto, quedamos en el recreo y fue super rápido.',
                'Buen trato, aunque tardó un poco en contestar.',
                'Material tal y como se describía en el anuncio. Recomendado.',
                'Trato excelente y apuntes super limpios.'
            ]),
        ];
    }
}
