<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Product::count() === 0) {
            $products = json_decode(file_get_contents(__DIR__ . '/data/products.json'), true);

            $bar = $this->command->getOutput()->createProgressBar(count($products));

            foreach ($products as $product) {
                Product::create([
                    'name'        => $product['name'],
                    'description' => $product['description'],
                    'price'       => $product['price'],
                    'stock'       => $product['stock'],
                    'available'   => $product['available'],
                    'section_id'  => $product['section_id'],
                ]);
                $bar->advance();
            }

            $bar->finish();
            echo "\n";
        }
    }
}
