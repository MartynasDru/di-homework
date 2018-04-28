<?php

namespace Nfq\WeatherBundle;

class YahooWeatherProvider implements WeatherProviderInterface
{
    public function fetch(Location $location) : Weather
    {
        $BASE_URL = "https://query.yahooapis.com/v1/public/yql";
        $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$location->getLocation().'") and u="c"';
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json&env=store://datatables.org/alltableswithkeys";
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);
        $phpObj =  json_decode($json);
        if (!isset($phpObj->query->results)){
            throw new WeatherProviderException("YahooWeatherProvider not working!");
        }

        $temperature = $phpObj->query->results->channel->item->condition->temp;

        return new Weather(23);
    }
}
?>