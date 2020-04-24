<?php

namespace App;
use Illuminate\Support\Facades\Cache;

trait GeoLocationMixin
{
    public function getGeoCoordinatesAttribute(): ?array
    {
        if (update_model_geolocation($this) === false)
            return null;

        $geo = $this->geolocation;
        if (!$geo || !isset($geo['Location']))
            // If no result is available but we did the query, we store just the timestamp to prevent the server banning us
            return null;
        return $geo['Location'];
    }

    public function getGeoCoordinatesStringAttribute(): ?string
    {
        $loc = $this->geo_coordinates;
        if (!$loc)
            return null;

        return "[{$loc['Lat_WGS84']}, {$loc['Lon_WGS84']}]";
    }

    public function getHasGeoLocationAttribute()
    {
        return $this->getGeoCoordinatesAttribute() !== null;
    }

    public static function getGeoList()
    {
        // Cache::forget(get_called_class() . '_geo_list');
        return Cache::remember(get_called_class() . '_geo_list', 3600, function() {
            $markers = [];

            foreach (static::cursor() as $user) {
                if ($loc = $user->geo_coordinates) {
                    $markers[] = [
                        'location' => $loc,
                        'location_string' => $user->geo_coordinates_string,
                        'name' => $user->title,
                        'id' => $user->id];
                }
            }
            return $markers;
        });
    }
}
