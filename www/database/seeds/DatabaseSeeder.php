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
        $this->call(ItemSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(BackupSeeder::class);
        #$this->call(MysterionSeeder::class);
    }
}
