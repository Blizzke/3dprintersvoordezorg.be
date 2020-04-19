<?php

use App\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'mondmasker_hulp', 'price' => 0.1],
            ['name' => 'safegrabber_rd', 'price' => 0.5],
            ['name' => 'mask_typeIIr', 'price' => 1],
            ['name' => 'faceshield', 'price' => 5],
        ];

        Item::unguard();
        foreach ($items as $row) {
            Item::create($row);
        }
        Item::reguard();
    }
}
