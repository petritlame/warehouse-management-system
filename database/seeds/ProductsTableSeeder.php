<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            DB::table('products')->insert([
                'emertimi' => $faker->name,
                'cmim_blerje' => $faker->randomFloat(4,10, 100),
                'cmim_shitje' => $faker->randomFloat(4,10, 100),
                'vlera_blerje' => 0.00,
                'vlera_shitje' => 0.00,
                'category_id' => $faker->numberBetween(1,4),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        foreach (range(1,10) as $index) {
            $cmim_blerje = DB::table('products')->where('id', $index)->value('cmim_blerje');
            $cmim_shitje = DB::table('products')->where('id', $index)->value('cmim_shitje');
            $sasia = DB::table('sasia')->where('product_id', $index)->value('sasia');
            $vlera_blerje = $cmim_blerje * $sasia;
            $vlera_shitje = $cmim_shitje * $sasia;

            DB::table('products')
                ->where('id', $index)
                ->update(['vlera_blerje' => $vlera_blerje, 'vlera_shitje'=>$vlera_shitje]);
        }
    }
}

