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
            ['type' => 'faceshield', 'name' => 'Gelaatsbeschermer', 'price' => 3.5, 'on_fp' => 1,
                'title' => 'Gelaatsbeschermer/Spatmasker',
                'description' => 'Wordt geprint in PETG met een A4 lamineerhoes of overhead transparant.<br>Voor model van foto: Bevestiging met knoopsgatrekker.<br/>Effectieve model kan afwijken van foto.',
                'images' => [
                    'large'=> 'faceshield_lg.jpg',
                ],
                'maker_info' => [
                    'STL File' => '<a href="https://www.prusaprinters.org/prints/25857-prusa-face-shield" target="_blank>">enkel</a>, <a href="https://www.prusaprinters.org/prints/27267" target="_blank">stacked/5</a>',
                    'Disclaimer' => '<a href="/files/covid-19.pdf">PDF</a> / <a href="/files/covid-19.docx">DOCX</a>',
                    'Materiaal' => 'PETG! (Geen PLA! Alleen in extreme gevallen als de klant de extra risico\'s begrijpt of er expliciet naar vraagt!)',
                    'Laagdikte' => '0.2mm - 0.3mm',
                    'Infill' => '20%',
                    'Supports' => 'geen',
                ]
            ],
            ['type' => 'mondmasker_hulp', 'name' => 'Ear saver', 'price' => 0.2, 'on_fp' => 2,
                'title' => 'Mondmasker bevestiging',
                'description' => 'Om de stress weg te nemen van je oren.',
                'images' => [
                    'large'=> 'mondmasker_hulp_lg.jpg',
                ],
                'maker_info' => [
                    'STL File' => '<a href="https://www.thingiverse.com/thing:4249113" target="_blank">hier (TV)</a> of <a href="/files/earsaver.stl">hier (lokaal)</a>',
                    'Materiaal' => 'PLA of PLA flex (PETG indien niet voor 1 persoon)',
                    'Laagdikte' => '0.2mm (0.3mm werkt ook)',
                    'Infill' => '20%',
                    'Supports' => 'geen',
                ]
            ],
            ['type' => 'safegrabber_rd', 'name' => 'Corona hook', 'price' => 0.5, 'on_fp' => 3,
                'title' => 'Corona hook/Safe Grabber',
                'description' => 'Vermijd het aanraken van risicovolle oppervlakken. Deuren openen etc.',
                'images' => [
                    'large'=> 'safegrabber_rd_lg.jpg',
                ],
                'maker_info' => [
                    'STL File' => '<a href="https://www.prusaprinters.org/prints/26146-savegrabber-open-door-without-touching-the-handle-" target="_blank">hier (PP, rd variant)</a> of <a href="/files/safegrabber_rd.stl">hier (lokaal)</a>',
                    'Materiaal' => 'PLA, PETG of ABS (PETG is te ontsmetten)',
                    'Laagdikte' => '0.2mm - 0.4mm',
                    'Infill' => 'minimaal 30%',
                    'Supports' => 'geen',
                ]
            ],
            ['type' => 'mask_typeIIr_zorg', 'name' => 'IIR mondmasker (zorgverlening)', 'price' => 42.5, 'vat_ex' => 1, 'is_max' => 0, 'sector' => '|zorgverlening|',
                'title' => 'Chirurgisch masker type IIR (zorg)',
                'description' => '<b>Alleen voor zorg en scholen!</b> 0.85&euro;/stuk exbtw. NIET individueel verpakt. Factuur is mogelijk<br />Technische fiche <a href="/files/masktypeiir.pdf">hier</a>.',
                'unit' => 'per doos van 50 stuks',
                'images' => [
                    'large'=> 'masktypeiir2_lg.jpg',
                ],
            ],
            ['type' => 'mask_typeIIr', 'name' => 'IIR mondmasker', 'price' => 50, 'vat_ex' => 1, 'is_max' => 0, 'on_fp' => 4,
                'title' => 'Chirurgisch masker type IIR',
                'description' => '1&euro;/stuk exbtw. NIET individueel verpakt. Factuur is mogelijk<br/>Technische fiche <a href="/files/masktypeiir.pdf">hier</a>.',
                'unit' => 'per doos van 50 stuks',
                'images' => [
                    'large'=> 'masktypeiir2_lg.jpg',
                ],
            ],
        ];

        Item::unguard();
        foreach ($items as $row) {
            $item = Item::whereType($row['type'])->first();
            if (!$item)
                Item::create($row);
            else
                foreach ($row as $attribute => $value) {
                    $item->{$attribute} = $value;
                    $item->save();
                }
        }
        Item::reguard();
    }
}
