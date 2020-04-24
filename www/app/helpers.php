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
            $model->{$geo_attribute} = $result;
            $model->save();
            return true;
        }
    }
    return false;
}
