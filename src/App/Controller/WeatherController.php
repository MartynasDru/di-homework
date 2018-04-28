<?php

namespace App\Controller;

use Nfq\WeatherBundle\Location;
use Nfq\WeatherBundle\WeatherProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WeatherController
{
    /**
     * @var WeatherProviderInterface
     */
    private $provider;

    public function __construct(WeatherProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function index(): Response
    {
        $location = new Location("Vilnius");
        $weather = $this->provider->fetch($location);

        return new Response(sprintf('Current temperature: %f', $weather->getTemperature()));
    }
}
