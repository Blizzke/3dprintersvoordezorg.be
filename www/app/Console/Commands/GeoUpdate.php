<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeoUpdate extends Command
{
    protected $signature = 'geo:update';
    protected $description = 'Fetch all coordinates for the helpers/customers';

    public function handle()
    {
        foreach (\App\Helper::cursor() as $helper) {

            echo 'Updating helper ', $helper->name, '... ';
            $result = update_model_geolocation($helper);
            echo ($result === true || $result === null) ? 'ok' : 'error';
            echo "\n";
            if ($result !== null)
                 sleep(2);
        }

        foreach (\App\Customer::cursor() as $helper) {
            echo 'Updating customer ', $helper->name, '... ';
            echo ($result === true || $result === null) ? 'ok' : 'error';
            echo "\n";
            if ($result !== null)
                 sleep(2);
        }
    }
}
