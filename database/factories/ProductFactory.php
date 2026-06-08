<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                    'Libro Matemáticas 2º DAW',
                    'Calculadora Científica Casio',
                    'Bata de Laboratorio Talla M',
                    'Libro Inglés B2 Upper',
                    'Apuntes de Sistemas Informáticos',
                    'Maletín de dibujo técnico',
                    'Teclado Mecánico USB'
                ]) . ' - ' . fake()->word(),
            'description' => fake()->paragraph(2),
            'price' => fake()->randomFloat(2, 5, 45),
            'item_condition' => fake()->randomElement(['new', 'good', 'worn']),
            'status' => 'available',
            'image_url' => 'https://source.unsplash.com/featured/600x600/?{$randomKeyword}',
            'seller_id' => User::where('role', 'student')->inRandomOrder()->first()->user_id,
            'category_id' => Category::inRandomOrder()->first()->category_id,
        ];
    }
}
