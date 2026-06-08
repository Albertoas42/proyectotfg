<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar caché de permisos de Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crear Roles y Permisos
        $manageProducts = Permission::create(['name' => 'moderar productos']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $adminRole->givePermissionTo($manageProducts);

        // 3. Crear Categorías
        $categories = [
            ['category_name' => 'Libros de Texto', 'description' => 'Libros oficiales.'],
            ['category_name' => 'Material Escolar', 'description' => 'Calculadoras, reglas...'],
            ['category_name' => 'Lectura', 'description' => 'Novelas obligatorias.'],
            ['category_name' => 'Tecnología', 'description' => 'Teclados, ratones...'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 4. Crear Administrador a mano (Y su perfil)
        $adminUser = User::create([
            'first_name' => 'Profe',
            'last_name' => 'Admin',
            'email' => 'admin@instituto.com',
            'password' => Hash::make('admin123'),
        ]);
        $adminUser->assignRole($adminRole);
        Profile::factory()->create(['user_id' => $adminUser->user_id, 'course' => 'Profesor / Administrador']);

        // 5. Crear tu cuenta de Alumno a mano (Y tu perfil)
        $normalUser = User::create([
            'first_name' => 'Alberto',
            'last_name' => 'Alumno',
            'email' => 'alberto@instituto.com',
            'password' => Hash::make('12345678'),
        ]);
        $normalUser->assignRole($userRole);
        Profile::factory()->create(['user_id' => $normalUser->user_id, 'course' => '2º DAW']);

        // 6. Crear 10 Alumnos falsos con sus respectivos Perfiles
        $fakeUsers = User::factory(10)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
            // Creamos el perfil asociado a este usuario concreto
            Profile::factory()->create(['user_id' => $user->user_id]);
        });

        // 7. Crear 20 Productos asignados aleatoriamente a los alumnos creados
        // Recogemos todos los usuarios menos al admin para que vendan cosas
        $sellers = User::whereHas('roles', function($q){ $q->where('name', 'user'); })->get();

        $products = Product::factory(20)->create()->each(function ($product) use ($sellers) {
            // Le asignamos un vendedor aleatorio de nuestra lista
            $product->update([
                'seller_id' => $sellers->random()->user_id
            ]);
        });

        // 8. Crear Valoraciones Artificiales (Reviews)
        // Vamos a simular que se han hecho 10 valoraciones cruzadas sobre los productos existentes
        for ($i = 0; $i < 10; $i++) {
            $product = $products->random();
            $vendedor = $product->seller_id;

            // Buscamos un comprador aleatorio que NO sea el propio vendedor del producto
            $comprador = $sellers->where('user_id', '!=', $vendedor)->random()->user_id;

            Review::factory()->create([
                'product_id' => $product->product_id,
                'reviewer_id' => $comprador,  // El que vota (comprador)
                'reviewee_id' => $vendedor,   // El votado (vendedor)
            ]);
        }
    }
}
