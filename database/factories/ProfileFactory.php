<?php

namespace Database\Factories;

use App\Models\Profile; // <-- AÑADE ESTA LÍNEA AQUÍ
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        // Lista de ciclos para que los datos parezcan de tu instituto
        $cursos = ['1º DAW', '2º DAW', '1º DAM', '2º DAM', '1º SMR', '2º SMR', 'Bachillerato Ciencias'];

        return [
            'bio' => $this->faker->randomElement([
                'Estudiante de informática. Suelo estar en el aula de DAW en el recreo.',
                'Vendo los libros del año pasado que ya no uso. Todo bien cuidado.',
                'Cambio apuntes y material de redes. Háblame sin compromiso!',
                'Hago limpieza de mochila. Calculadoras y reglas baratas.',
                'Si necesitas libros de lengua o inglés, tengo varios disponibles.'
            ]),
            'course' => $this->faker->randomElement($cursos),
            'avatar_path' => null,
            'is_verified' => $this->faker->boolean(30),
        ];
    }
}
