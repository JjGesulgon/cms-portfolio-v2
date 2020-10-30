<?php

use App\Passion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categories')->insert([
        'user_id' => 1,
        'name' => 'Life',
        'created_at' => Carbon::now()
      ]);

      DB::table('categories')->insert([
        'user_id' => 1,
        'name' => 'Tech',
        'created_at' => Carbon::now()
      ]);

      DB::table('categories')->insert([
        'user_id' => 1,
        'name' => 'Productivity',
        'created_at' => Carbon::now()
      ]);
    }
}
