<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client::class, 30)->create()->each(function ($client) {
          $client->user()->save(factory(App\User::class)->make());});
    }
}