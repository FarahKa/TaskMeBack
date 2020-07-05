<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id=\App\Category::where("name", "gardening")->first()->id;


        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "mowing",
            'description' => 'Mowing the lawn',
        ]);

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "watering",
        ]);

        $id=\App\Category::where("name", "computers")->first()->id;

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "teaching",
        ]);

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "excel",
        ]);

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "community_management",
        ]);

        $id=\App\Category::where("name", "errands")->first()->id;
        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "shopping",
        ]);

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "sewing",
        ]);

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "pressing",
        ]);
        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "driving",
        ]);

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "delivering",
        ]);

        DB::table('tasks')->insert([
            'category_id' => $id,
            'name' => "ticket_buying",
        ]);
    }
}
