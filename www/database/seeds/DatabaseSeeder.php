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
        // First the backup, since items and features update existing data, but vice versa wont work
        $this->call(BackupSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(FeatureSeeder::class);
        #$this->call(MysterionSeeder::class);
    }
}
