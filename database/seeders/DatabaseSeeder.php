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
        $albertoUser = User::create([
            'first_name' => 'Alberto',
            'last_name' => 'Alumno',
            'email' => 'alberto@instituto.com',
            'password' => Hash::make('12345678'),
        ]);
        $albertoUser->assignRole($userRole);
        Profile::factory()->create(['user_id' => $albertoUser->user_id, 'course' => '2º DAW']);

        // 6. Crear 10 Alumnos falsos con sus respectivos Perfiles
        $fakeUsers = User::factory(10)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
            Profile::factory()->create(['user_id' => $user->user_id]);
        });

        // Colección de todos los alumnos normales (tú + los falsos) para asignar ventas y compras
        $sellers = User::whereHas('roles', function($q){ $q->where('name', 'user'); })->get();

        // 7. Crear 20 Productos asignados directamente a vendedores aleatorios
        $products = Product::factory(20)->create([
            'seller_id' => fn() => $sellers->random()->user_id
        ]);

        // 8. Crear Valoraciones Artificiales (Reviews)
        for ($i = 0; $i < 10; $i++) {
            $product = $products->random();
            $vendedor = $product->seller_id;
            $comprador = $sellers->where('user_id', '!=', $vendedor)->random()->user_id;

            Review::factory()->create([
                'product_id' => $product->product_id,
                'reviewer_id' => $comprador,
                'reviewee_id' => $vendedor,
            ]);
        }

        // =========================================================================
        // 9. 🚨 NUEVO: GENERACIÓN DE CHATS Y MENSAJES DE PRUEBA (MÁXIMA COMPATIBILIDAD)
        // =========================================================================

        // Chat 1: Un alumno falso te escribe a TI (Alberto) por un producto tuyo
        $productoDeAlberto = Product::factory()->create([
            'title' => 'Libro de PHP y Laravel de 2º DAW',
            'seller_id' => $albertoUser->user_id,
            'category_id' => Category::first()->category_id,
            'price' => 15.00,
            'item_condition' => 'good'
        ]);

        $compradorFalso = $fakeUsers->random();

        $chat1 = Chat::create([
            'product_id' => $productoDeAlberto->product_id,
            'buyer_id'   => $compradorFalso->user_id,
            'seller_id'  => $albertoUser->user_id,
        ]);

        Message::create([
            'chat_id'   => $chat1->id,
            'sender_id' => $compradorFalso->user_id,
            'content'   => '¡Hola Alberto! ¿El libro de PHP tiene las páginas pintadas o está limpio?',
        ]);

        Message::create([
            'chat_id'   => $chat1->id,
            'sender_id' => $albertoUser->user_id,
            'content'   => 'Buenas. Qué va, está impecable, solo tiene subrayadas a lápiz un par de cosas del tema de bases de datos.',
        ]);

        // Chat 2: TU (Alberto) le escribes a otro alumno por un producto suyo
        $productoDeOtro = $products->where('seller_id', '!=', $albertoUser->user_id)->random();

        // Evitamos duplicados por si la combinación aleatoria ya existiera
        $chat2Exists = Chat::where('product_id', $productoDeOtro->product_id)
            ->where('buyer_id', $albertoUser->user_id)
            ->exists();

        if (!$chat2Exists) {
            $chat2 = Chat::create([
                'product_id' => $productoDeOtro->product_id,
                'buyer_id'   => $albertoUser->user_id,
                'seller_id'  => $productoDeOtro->seller_id,
            ]);

            Message::create([
                'chat_id'   => $chat2->id,
                'sender_id' => $albertoUser->user_id,
                'content'   => 'Hola, me interesa este artículo que has subido. ¿Me lo dejas un poco más barato si te lo recojo mañana?',
            ]);
        }
    }
}
