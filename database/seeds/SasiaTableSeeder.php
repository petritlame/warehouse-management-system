<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SasiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sasia')->truncate();
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {
            DB::table('sasia')->insert([
                'product_id' => $index,
                'sasia' => $faker->numberBetween(20, 80),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
