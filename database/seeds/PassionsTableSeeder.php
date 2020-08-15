<?php

use App\Passion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PassionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('passions')->insert([
        'user_id' => 1,
        'name' => 'Technology',
        'description' => '<p>Technology is Awesome</p>',
        'image' => null,
        'created_at' => Carbon::now()
      ]);

      DB::table('passions')->insert([
        'user_id' => 1,
        'name' => 'Design',
        'description' => '<p>Design is Awesome</p>',
        'image' => null,
        'created_at' => Carbon::now()
      ]);

      DB::table('passions')->insert([
        'user_id' => 1,
        'name' => 'Story',
        'description' => '<p>Story is Awesome</p>',
        'image' => null,
        'created_at' => Carbon::now()
      ]);
    }
}
