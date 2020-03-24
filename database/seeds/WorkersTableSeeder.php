<?php

use Illuminate\Database\Seeder;

class WorkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $worker= factory(App\Worker::class, 30)->create()->each(function ($worker) {
        $worker->user()->save(factory(App\User::class)->make());});
    }
}
