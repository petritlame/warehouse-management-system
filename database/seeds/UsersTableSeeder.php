<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('users')->get();
        if (count($id) === 0) {
            DB::table('categories')->truncate();
            DB::table('users')->insert([
                'name' => 'Magazina',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456789'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
