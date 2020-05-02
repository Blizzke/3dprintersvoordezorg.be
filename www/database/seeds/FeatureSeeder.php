<?php

use App\Feature;
use App\Item;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            ['type' => 'notification', 'value' => 'please_add_features', 'name' => 'Heeft de "voeg features toe"-notification gezien'],
            ['type' => 'notification', 'value' => 'please_add_material', 'name' => 'Heeft de "selecteer je materialen"-notification gezien'],
            ['type' => 'agreement', 'value' => 'who_what_where', 'name' => 'Beweert de "wie, wat waar?"-pagina gelezen te hebben'],
            ['type' => 'auth', 'value' => 'dispatcher', 'name' => 'Kan gelockte bestellingen vrijgeven naar de queue'],
            ['type' => 'auth', 'value' => 'cancel', 'name' => 'Kan bestellingen annuleren'],
            ['type' => 'auth', 'value' => 'dispatcher', 'name' => 'Kan gelockte bestellingen vrijgeven naar de queue'],
            ['type' => 'auth', 'value' => 'unlocker', 'name' => 'Kan nieuwe accounts unlocken'],
            ['type' => 'account', 'value' => 'unlocked', 'name' => 'Account is ge-unlocked en kan bestellingen aanvaarden'],
            ['type' => 'capacity', 'value' => 'shipping', 'name' => 'Ik kan items opsturen', "modifiable" => 1],
            ['type' => 'capacity', 'value' => 'storage', 'name' => 'Ik wil stockeren voor verdere verspreiding (andere helpers komen leveren en halen)', "modifiable" => 1],
            ['type' => 'capacity', 'value' => 'driver', 'name' => 'Ik wil rondrijden om materiaal te bezorgen', "modifiable" => 1],
            ['type' => 'capacity', 'value' => 'invoice', 'name' => 'Ik kan facturen maken', "modifiable" => 1],
            ['type' => 'capacity', 'value' => 'visors', 'name' => 'Gedeeltelijke spatschermen: Ik kan vizieren maken (lamineren, laseren, transparantsheet)', "modifiable" => 1],
            ['type' => 'capacity', 'value' => 'elastic', 'name' => 'Gedeeltelijke spatschermen: Ik kan de elastic straps maken', "modifiable" => 1],
            ['type' => 'capacity', 'value' => 'headband', 'name' => 'Gedeeltelijke spatschermen: Ik kan beugels printen', "modifiable" => 1],
            ['type' => 'material', 'value' => 'pla', 'name' => 'Ik kan PLA printen', "modifiable" => 1],
            ['type' => 'material', 'value' => 'petg', 'name' => 'Ik kan PETG printen', "modifiable" => 1],
        ];

        // All items are features
        foreach (Item::all() as $item)
            $features[] = ['type' => 'item', 'value' => $item->type, 'name' => "Ik maak/heb item: \"{$item->title}\"", "modifiable" => 1];

        Feature::unguard();
        foreach ($features as $row) {
            $feature = Feature::whereType($row['type'])->whereValue($row['value'])->first();
            if (!$feature)
                Feature::create($row);
            else
                foreach ($row as $attribute => $value) {
                    $feature->{$attribute} = $value;
                    $feature->save();
                }
        }
        Feature::reguard();
    }
}
