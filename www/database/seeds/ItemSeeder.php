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
            ['type' => 'mondmasker_hulp', 'name' => 'Ear saver', 'price' => 0.1],
            ['type' => 'safegrabber_rd', 'name' => 'Corona hook', 'price' => 0.5],
            ['type' => 'mask_typeIIr_zorg', 'name' => 'IIR mondmasker (zorgverlening)', 'price' => 0.85, 'vat_ex' => 1, 'is_max' => 0, 'sector' => '|zorgverlening|'],
            ['type' => 'mask_typeIIr', 'name' => 'IIR mondmasker', 'price' => 1, 'vat_ex' => 1, 'is_max' => 0],
            ['type' => 'faceshield', 'name' => 'Gelaatsbeschermer', 'price' => 5],
        ];

        Item::unguard();
        foreach ($items as $row) {
            Item::create($row);
        }
        Item::reguard();
    }
}
