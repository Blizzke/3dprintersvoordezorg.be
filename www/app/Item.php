<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $casts = [
        'is_max' => 'boolean',
        'vat_ex' => 'vat_ex',
        'images' => 'array',
        'maker_info' => 'array',
    ];

    public function getVerbosePriceAttribute(): string
    {
        $parts = [];
        if ($this->is_max) {
            $parts[] = 'maximum';
        }
        $parts[] = (string) $this->price . '€';
        if ($this->vat_ex) {
            $parts[] = 'exbtw (' . number_format($this->price * (1+($this->vat / 100)), 2) . '€)';
        }
        return implode(' ', $parts);
    }

    public function for_sector($sector)
    {
        if (empty($this->sector)) {
            return true;
        }

        return strpos($this->sector, "|$sector|") !== false;
    }

    public function image($type = 'large')
    {
        if (!array_key_exists($type, $this->images))
            return '/images/items/' . $this->images['large'];
        return '/images/items/' . $this->images[$type];
    }
}
