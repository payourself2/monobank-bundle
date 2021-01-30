<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('payourself2_monobank');

        $treeBuilder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('api_base_path')
            ->defaultValue('https://api.monobank.ua')
            ->end()
            ->scalarNode('personal_key')
            ->defaultValue('')
            ->end()
            ->scalarNode('pub_key')
            ->defaultValue('')
            ->end()
            ->scalarNode('priv_key')
            ->defaultValue('')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
