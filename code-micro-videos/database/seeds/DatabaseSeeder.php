<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Category::class, 100)->create();
        factory(\App\Models\Genre::class, 100)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
