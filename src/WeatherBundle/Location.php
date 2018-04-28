<?php
namespace Nfq\WeatherBundle;
class Location
{
    private $city;
    public function __construct($city)
    {
        $this->city = $city;
    }
    public function getLocation()
    {
        return $this->city;
    }
}
?>