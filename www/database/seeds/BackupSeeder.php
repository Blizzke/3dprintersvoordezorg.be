<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class BackupSeeder
 * Restores a mysql dump from the database
 */
class BackupSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        DB::unprepared(Storage::disk('www')->get('printers3d_corona.sql'));
        Model::reguard();
    }
}
