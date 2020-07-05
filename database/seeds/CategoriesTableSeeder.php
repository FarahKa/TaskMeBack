<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'name' => "gardening",
            'description' => 'Garden care',
        ]);

        DB::table('categories')->insert([
            'name' => "computers",
            'description' => 'All computer stuff!',
        ]);

        DB::table('categories')->insert([
            'name' => "events",
            'description' => 'Need help during your event?',
        ]);

        DB::table('categories')->insert([
            'name' => "gardening",
            'description' => 'Keep your garden healthy with  a little help...',
        ]);

        DB::table('categories')->insert([
            'name' => "errands",
            'description' => 'No need to move!',
        ]);

        DB::table('categories')->insert([
            'name' => "cleaning",
            'description' => 'Keep it all spotless.',
        ]);



        DB::table('categories')->insert([
            'name' => "organizing",
            'description' => 'Declutter your house!',
        ]);

        DB::table('categories')->insert([
            'name' => "manpower",
            'description' => 'We need strength here!',
        ]);

        DB::table('categories')->insert([
            'name' => "planning",
            'description' => 'Your own personal planner.',
        ]);
    }
}
