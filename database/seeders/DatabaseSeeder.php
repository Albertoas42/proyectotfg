<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Roles y Permisos
        $manageProducts = Permission::create(['name' => 'moderar productos']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $adminRole->givePermissionTo($manageProducts);

        // 2. Categorías
        $categories = [
            ['category_name' => 'Libros', 'description' => 'Libros y apuntes.'],
            ['category_name' => 'Material', 'description' => 'Calculadoras, material de dibujo.'],
            ['category_name' => 'Tecnología', 'description' => 'Periféricos y gadgets.'],
        ];
        foreach ($categories as $cat) { Category::create($cat); }

        // 3. Usuarios Base
        $adminUser = User::create(['first_name' => 'Profe', 'last_name' => 'Admin', 'email' => 'admin@instituto.com', 'password' => Hash::make('admin123')]);
        $adminUser->assignRole($adminRole);
        Profile::factory()->create(['user_id' => $adminUser->user_id, 'course' => 'Profesor']);

        $albertoUser = User::create(['first_name' => 'Alberto', 'last_name' => 'Alumno', 'email' => 'alberto@instituto.com', 'password' => Hash::make('12345678')]);
        $albertoUser->assignRole($userRole);
        Profile::factory()->create(['user_id' => $albertoUser->user_id, 'course' => '2º DAW']);

        // 4. Usuarios Falsos
        $fakeUsers = User::factory(5)->create()->each(fn($u) => $u->assignRole($userRole) && Profile::factory()->create(['user_id' => $u->user_id]));
        $allUsers = User::whereHas('roles', fn($q) => $q->where('name', 'user'))->get();

        // 5. Arrays de datos reales para productos
        $datosProductos = [
            ['title' => 'Calculadora Casio FX-991SP', 'price' => 15, 'cat' => 2, 'desc' => 'Muy bien cuidada, pilas recién cambiadas.'],
            ['title' => 'Libro Historia 2º Bach', 'price' => 20, 'cat' => 1, 'desc' => 'Edición 2024, sin anotaciones.'],
            ['title' => 'Teclado Mecánico Redragon', 'price' => 35, 'cat' => 3, 'desc' => 'Lo vendo porque he comprado uno nuevo.'],
            ['title' => 'Escuadra y Cartabón profesional', 'price' => 5, 'cat' => 2, 'desc' => 'Imprescindibles para Dibujo Técnico.'],
            ['title' => 'Apuntes de Bases de Datos', 'price' => 10, 'cat' => 1, 'desc' => 'Resúmenes completos de todo el curso.'],
        ];

        $locations = ['Patio Central', 'Biblioteca', 'Cantina', 'Entrada Principal'];

        // 6. Crear Productos con datos reales
        foreach ($datosProductos as $p) {
            Product::create([
                'title' => $p['title'],
                'description' => $p['desc'],
                'price' => $p['price'],
                'item_condition' => 'good',
                'status' => 'available',
                'category_id' => $p['cat'],
                'seller_id' => $allUsers->random()->user_id,
                'location' => $locations[array_rand($locations)],
            ]);
        }

        // 7. Chat de prueba específico
        $prod = Product::first();
        $chat = Chat::create([
            'product_id' => $prod->product_id,
            'buyer_id' => $fakeUsers->random()->user_id,
            'seller_id' => $albertoUser->user_id
        ]);
        Message::create(['chat_id' => $chat->id, 'sender_id' => $chat->buyer_id, 'content' => '¿Sigue disponible?']);
    }
}
