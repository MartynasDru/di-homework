<?php

namespace Nfq\WeatherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nfq_weather');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
                ->children()
                    ->scalarNode('provider')
                        ->isRequired()
                    ->end()
                    ->arrayNode('providers')
                        ->children()
                            ->arrayNode('openweathermap')
                                ->children()
                                    ->scalarNode('api_key')
                                        ->defaultValue('secretapikey')
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('delegating')
                                ->children()
                                    ->arrayNode("providers")
                                        ->scalarPrototype()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end();

        return $treeBuilder;
    }
}
