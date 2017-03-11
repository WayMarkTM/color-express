<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/11/2017
 * Time: 3:50 PM
 */

namespace app\services;

use Yii;

class GoogleGeocodingService {

    /**
     * Get coordinates by address using Google Maps API
     *
     * @param $address
     * @return array [lat, lang];
     */
    public function geocode($address) {
        $address = urlencode($address);
        $url = Yii::$app->params['googleMapsGeocodeApiUrl'].'?address='.$address;

        $response = json_decode(file_get_contents($url), true);

        if ($response['status'] == 'OK') {
            $lat = $response['results'][0]['geometry']['location']['lat'];
            $long = $response['results'][0]['geometry']['location']['lng'];

            if ($lat && $long) {
                return array("lat" => $lat, "long" => $long);
            }
        }

        return false;

    }
}