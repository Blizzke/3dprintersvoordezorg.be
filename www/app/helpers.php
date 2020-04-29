<?php


use App\Customer;
use App\Helper;
use Illuminate\Support\Facades\Auth;

function is_helper()
{
    return Auth::user() instanceof Helper;
}

function is_customer()
{
    return Auth::user() instanceof Customer;
}

function pretty_time($time)
{
    if ($time instanceof DateTime) {
        $carbon = \Carbon\Carbon::instance($time);
    }
    else {
        $carbon = \Carbon\Carbon::parse($time, 'UTC');
    }
    return $carbon->format('d/m/Y H:i');
}

/**
 * Updates the given models' geolocation field.
 * If the query fails (not enough details or unknown) only the update timestamp will be saved to prevent
 * server hammering.
 *
 * @param Helper|Customer $model
 * @param string[] $fields  The fields to use to assemble the location query
 * @param string $geo_attribute
 * @return bool|null    null: no update has occurred, true/false: updated with result / with timestamp
 */
function update_model_geolocation($model, $fields = ['street', 'number', 'zip', 'city'], $geo_attribute = 'geolocation')
{
    $current = $model->{$geo_attribute};
    if ($current && isset($current['Updated']) && $current['Updated'] + 86400 > time()) {
        // Max 1 update per 24h
        return null;
    }

    $query = [];
    foreach ($fields as $field)
        $query[] = $model->{$field};
    $query = implode(' ', array_filter($query));

    $result = call_geo_api($query);
    $return = true;
    if (!$result) {
        // No result but store the attempt anyway.
        $return = false;
        $result = ['Updated' => time()];
    }
    $model->{$geo_attribute} = $result;
    $model->save();

    return $return;
}

function call_geo_api($query)
{
    $client = new GuzzleHttp\Client();
    /** @var \GuzzleHttp\Psr7\Response $res */
    $res = $client->request('GET', 'http://loc.geopunt.be/v4/Location', [
        'query' => ['q' => $query]
    ]);
    if ($res->getStatusCode() == 200) {
        $result = json_decode($res->getBody(), true);
        if ($result && isset($result['LocationResult'][0])) {
            $result = $result['LocationResult'][0];
            $result['Updated'] = time();
            return $result;
        }
    }
    return false;
}


/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  return $angle * $earthRadius;
}


function input($model, $attribute) {
    return old($attribute) ?? object_get($model, $attribute);
}
