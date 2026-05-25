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
        // 1. Crear las Categorías fijas de nuestro Marketplace
        $categories = [
            ['category_name' => 'Libros de Texto', 'description' => 'Libros oficiales de ciclos y bachillerato.'],
            ['category_name' => 'Material Escolar', 'description' => 'Calculadoras, reglas, estuches y mochilas.'],
            ['category_name' => 'Lectura', 'description' => 'Novelas y libros obligatorios para lengua o idiomas.'],
            ['category_name' => 'Tecnología', 'description' => 'Teclados, ratones y componentes informáticos.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 2. Crear un usuario Administrador fijo (Para que puedas testear el panel de admin)
        User::create([
            'first_name' => 'Profe',
            'last_name' => 'Admin',
            'email' => 'admin@instituto.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 3. Crear un Alumno fijo de prueba (Para loguearte tú directamente sin registrarte)
        User::create([
            'first_name' => 'Alberto',
            'last_name' => 'Alumno',
            'email' => 'alberto@instituto.com',
            'password' => Hash::make('12345678'), // Cumple los 8 caracteres de Breeze
            'role' => 'student',
        ]);

        // 4. Crear 10 alumnos aleatorios usando la Factory
        User::factory(10)->create();

        // 5. Crear 20 productos aleatorios vinculados a esos alumnos y categorías
        Product::factory(20)->create();
    }
}
