<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Caña de Carbono X1',
                'description' => 'Caña forjada con fibra de carbono de alto módulo, diseñada específicamente para las exigentes condiciones de la costa canaria. Su acción de punta permite lances extremadamente largos y una sensibilidad excepcional para detectar hasta la picada más sutil en fondos rocosos.',
                'price' => 129.00,
                'stock' => 10,
                'category' => 'Cañas',
                'image' => 'imagenes/caña.png'
            ],
            [
                'name' => 'Carrete Silver Stream',
                'description' => 'Ingeniería de precisión en cada giro. Este carrete cuenta con un cuerpo sellado de aluminio aeroespacial y 9+1 rodamientos de acero inoxidable resistentes a la corrosión salina. Su sistema de freno progresivo garantiza una salida de hilo suave incluso bajo la presión de las capturas más potentes del Atlántico.',
                'price' => 89.00,
                'stock' => 5,
                'category' => 'Carretes',
                'image' => 'imagenes/carrete.png'
            ],
            [
                'name' => 'Kit de Señuelos Rapala',
                'description' => 'Colección exclusiva de 5 señuelos de alta eficacia, seleccionados por expertos pescadores locales. Incluye modelos con natación errática y acabados holográficos que imitan a la perfección el movimiento de lisas y bogas, irresistibles para depredadores como el robalo o la anjova.',
                'price' => 40.00,
                'stock' => 8,
                'category' => 'Señuelos',
                'image' => 'imagenes/senuelo.png'
            ],
            [
                'name' => 'Anzuelos Gamakatsu',
                'description' => 'El estándar de oro en clavada. Fabricados con acero al carbono de alta pureza y sometidos a un proceso de afilado químico, estos anzuelos garantizan una penetración instantánea y segura. Su recubrimiento especial evita la oxidación prematura tras largas jornadas en el muelle o el roqueo.',
                'price' => 12.50,
                'stock' => 50,
                'category' => 'Accesorios',
                'image' => 'imagenes/anzuelos.png'
            ],
            [
                'name' => 'Hilo Trenzado 0.30mm',
                'description' => 'Tecnología de 8 hebras de polietileno de ultra alto peso molecular. Este hilo ofrece un diámetro mínimo con una resistencia a la rotura incomparable y una elasticidad cero para un control total. Su color vibrante mejora la visibilidad sobre el azul profundo, facilitando el seguimiento de la línea en condiciones de fuerte corriente.',
                'price' => 25.00,
                'stock' => 15,
                'category' => 'Hilos',
                'image' => 'imagenes/hilo.png'
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }
    }
}
