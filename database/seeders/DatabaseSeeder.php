<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Libros de Texto', 'description' => 'Libros oficiales de ciclos y bachillerato.'],
            ['category_name' => 'Material Escolar', 'description' => 'Calculadoras, reglas, estuches y mochilas.'],
            ['category_name' => 'Lectura', 'description' => 'Novelas y libros obligatorios para lengua o idiomas.'],
            ['category_name' => 'Tecnología', 'description' => 'Teclados, ratones y componentes informáticos.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        User::create([
            'first_name' => 'Profe',
            'last_name' => 'Admin',
            'email' => 'admin@instituto.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'first_name' => 'Alberto',
            'last_name' => 'Alumno',
            'email' => 'alberto@instituto.com',
            'password' => Hash::make('12345678'),
            'role' => 'student',
        ]);

        User::factory(10)->create();

        Product::factory(20)->create();
    }
}
