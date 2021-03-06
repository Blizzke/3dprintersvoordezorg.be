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

    public function distanceFrom($from)
    {
        if (!is_array($from) && method_exists($from, 'getGeoCoordinatesAttribute')) {
            $from = $from->getGeoCoordinatesAttribute();
        }

        if (!$from) {
            return null;
        }

        $from = array_slice(array_values($from), 0, 2);
        $location = $this->getGeoCoordinatesAttribute();
        if ($location) {
            $location = array_slice(array_values($location), 0, 2);
            return number_format(haversineGreatCircleDistance(...$from, ...$location)/1000, 2) . 'km';
        }
        return null;
    }

    public static function getGeoList($distance_from = null)
    {
        if (!is_array($distance_from) && method_exists($distance_from, 'getGeoCoordinatesAttribute')) {
            $distance_from = $distance_from->getGeoCoordinatesAttribute();
        }

        if (!$distance_from) {
            return [];
        }

        // Cache::forget(get_called_class() . '_geo_list');
        $users = Cache::remember(get_called_class() . '_geo_list', 60, function() {
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

        if ($distance_from) {
            $distance_from = array_slice(array_values($distance_from), 0, 2);

            foreach($users as $index => $user) {
                $location = array_slice(array_values($user['location']), 0, 2);
                $users[$index]['distance'] = number_format(haversineGreatCircleDistance(...$distance_from, ...$location)/1000, 2) . 'km';
            }
            $users = collect($users)->sortBy('distance', SORT_NUMERIC)->toArray();
        }

        return $users;
    }
}
