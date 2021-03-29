<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('payourself2_monobank');
        /** @var ArrayNodeDefinition $parametersNode */
        $parametersNode = $treeBuilder->getRootNode();

        $ch = $parametersNode->addDefaultsIfNotSet()->children();
        $ch->scalarNode('api_base_path')
            ->defaultValue('https://api.monobank.ua')
            ->end();
        $ch->scalarNode('personal_key')
            ->defaultValue('')
            ->end();
        $ch->scalarNode('pub_key')
            ->defaultValue('')
            ->end();
        $ch->scalarNode('priv_key')
            ->defaultValue('')
            ->end();

        $ch->end();

        return $treeBuilder;
    }
}
