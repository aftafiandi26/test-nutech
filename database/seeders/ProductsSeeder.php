<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 100; $i++) {

            $data = [
                'image' => 'public/products/kfc.jpg',
                'name' => 'kfc' . $i,
                'buy'   => rand(100, 1000) . '0000',
                'sell'   => rand(200, 2000) . '0000',
                'stock'   => rand(10, 100)
            ];
            Products::create($data);
        }
    }
}
