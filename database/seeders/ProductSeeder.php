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
                'description' => 'Caña de alta resistencia para pesca de costa.',
                'price' => 129.00,
                'stock' => 10,
                'category' => 'Cañas',
                'image' => 'imagenes/pescador.jpeg'
            ],
            [
                'name' => 'Carrete Silver Stream',
                'description' => 'Carrete con rodamiento de acero inoxidable.',
                'price' => 89.00,
                'stock' => 5,
                'category' => 'Carretes',
                'image' => 'imagenes/carrete.png'
            ],
            [
                'name' => 'Kit de Señuelos Rapala',
                'description' => 'Set de 5 señuelos variados para diferentes especies.',
                'price' => 40.00,
                'stock' => 8,
                'category' => 'Señuelos',
                'image' => 'imagenes/senuelo.png'
            ],
            [
                'name' => 'Anzuelos Gamakatsu',
                'description' => 'Caja de 20 anzuelos ultra afilados.',
                'price' => 12.50,
                'stock' => 50,
                'category' => 'Accesorios',
                'image' => 'imagenes/jurel.jpg'
            ],
            [
                'name' => 'Hilo Trenzado 0.30mm',
                'description' => 'Bobina de 300m de hilo trenzado de alta visibilidad.',
                'price' => 25.00,
                'stock' => 15,
                'category' => 'Hilos',
                'image' => 'imagenes/mero.jpg'
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }
    }
}
