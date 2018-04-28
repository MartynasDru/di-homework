<?php

namespace Nfq\WeatherBundle\DependencyInjection;

use Nfq\WeatherBundle\OpenWeatherMapWeatherProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Nfq\WeatherBundle\WeatherProviderInterface;

class NfqWeatherExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('providers.yaml');

        if (isset($config['providers']['openweathermap']['api_key'])) {
            $container->getDefinition('nfq_weather.provider.openweathermap')
                ->replaceArgument(0, $config['providers']['openweathermap']['api_key']);
        }

        if (isset($config['providers']['delegating'])) {
            $owmwp = $container->getDefinition('nfq_weather.provider.openweathermap');
            $ywp = $container->getDefinition('nfq_weather.provider.yahoo');
            $container->getDefinition('nfq_weather.provider.delegating')
                ->replaceArgument(0, [$owmwp, $ywp]);
        }

        $container->setAlias(WeatherProviderInterface::class, 'nfq_weather.provider.'.$config['provider']);

    }
}
