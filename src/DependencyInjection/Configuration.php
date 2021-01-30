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
            ->children()
            ->scalarNode('api_base_path')->end()
            ->scalarNode('personal_key')->end()
            ->scalarNode('pub_key')->end()
            ->scalarNode('priv_key')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
