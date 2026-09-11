<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\PortfolioItem;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@donaross.com'],
            ['name' => 'Administrador', 'password' => Hash::make('admin123'), 'role' => 'admin', 'telefono' => '70000001', 'activo' => true]
        );

        User::updateOrCreate(
            ['email' => 'personal@donaross.com'],
            ['name' => 'María García', 'password' => Hash::make('personal123'), 'role' => 'personal', 'telefono' => '70000002', 'activo' => true]
        );

        User::updateOrCreate(
            ['email' => 'cliente@correo.com'],
            ['name' => 'Juan Pérez', 'password' => Hash::make('cliente123'), 'role' => 'cliente', 'telefono' => '70000003', 'direccion' => 'Av. Principal #456', 'activo' => true]
        );

        $cat1 = Categoria::firstOrCreate(['nombre' => 'Platos Principales'], ['descripcion' => 'Nuestros platos estrella', 'activo' => true]);
        $cat2 = Categoria::firstOrCreate(['nombre' => 'Bebidas'], ['descripcion' => 'Refrescos y jugos naturales', 'activo' => true]);
        $cat3 = Categoria::firstOrCreate(['nombre' => 'Postres'], ['descripcion' => 'Dulces caseros', 'activo' => true]);

        $productos = [
            ['nombre' => 'Silpancho Tradicional', 'descripcion' => 'Carne, arroz, papa y huevo frito.', 'precio' => 35, 'stock' => 50, 'destacado' => true, 'categoria_id' => $cat1->id],
            ['nombre' => 'Fricasé Paceño', 'descripcion' => 'Cerdo cocido con chuño y maíz.', 'precio' => 30, 'stock' => 40, 'destacado' => true, 'categoria_id' => $cat1->id],
            ['nombre' => 'Pique Macho', 'descripcion' => 'Carne, salchichas, papas fritas y huevo.', 'precio' => 45, 'stock' => 30, 'destacado' => true, 'categoria_id' => $cat1->id],
            ['nombre' => 'Jugo de Limonada', 'descripcion' => 'Limonada natural refrescante.', 'precio' => 8, 'stock' => 100, 'destacado' => false, 'categoria_id' => $cat2->id],
            ['nombre' => 'Postre de Helado', 'descripcion' => 'Helado artesanal de vainilla.', 'precio' => 12, 'stock' => 25, 'destacado' => false, 'categoria_id' => $cat3->id],
        ];

        foreach ($productos as $p) {
            Producto::updateOrCreate(['nombre' => $p['nombre']], array_merge($p, ['activo' => true]));
        }

        Promocion::firstOrCreate(
            ['titulo' => '2x1 los Jueves'],
            ['descripcion' => 'Dos platos principales al precio de uno todos los jueves.', 'descuento_porcentaje' => 50, 'fecha_inicio' => now(), 'fecha_fin' => now()->addMonths(3), 'activo' => true]
        );

        Promocion::firstOrCreate(
            ['titulo' => 'Combo Familiar Ross'],
            ['descripcion' => '4 platos principales + jarra de refresco + postre de cortesía.', 'descuento_porcentaje' => 20, 'activo' => true]
        );

        PortfolioItem::firstOrCreate(
            ['tipo' => 'sobre_mi', 'titulo' => 'Desarrollador Web'],
            ['descripcion' => 'Estudiante de ingeniería de sistemas apasionado por crear soluciones web con Laravel, PHP y MySQL.', 'orden' => 0, 'activo' => true]
        );

        $portfolioData = [
            ['tipo' => 'habilidad', 'titulo' => 'PHP / Laravel', 'orden' => 1],
            ['tipo' => 'habilidad', 'titulo' => 'MySQL', 'orden' => 2],
            ['tipo' => 'habilidad', 'titulo' => 'Bootstrap', 'orden' => 3],
            ['tipo' => 'habilidad', 'titulo' => 'JavaScript', 'orden' => 4],
            ['tipo' => 'proyecto', 'titulo' => 'Sistema Doña Ross', 'descripcion' => 'Sistema web completo para restaurante con roles, CRUD y carrito de compras.', 'tecnologias' => 'Laravel, MySQL, Bootstrap', 'orden' => 1],
            ['tipo' => 'experiencia', 'titulo' => 'Práctica Profesional', 'descripcion' => 'Desarrollo de sistemas web para negocios locales.', 'orden' => 1],
            ['tipo' => 'educacion', 'titulo' => 'Ingeniería de Sistemas', 'descripcion' => 'Universidad — En curso', 'orden' => 1],
        ];

        foreach ($portfolioData as $item) {
            PortfolioItem::firstOrCreate(
                ['tipo' => $item['tipo'], 'titulo' => $item['titulo']],
                array_merge($item, ['activo' => true])
            );
        }
    }
}
