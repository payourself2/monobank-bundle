<?php

namespace Payourself2\Bundle\MonobankBundle\DependencyInjection;

use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Client\PersonalClient;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MonobankExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yaml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition(PersonalClient::class);
        $definition->replaceArgument(3, $config['personal_key']);

        $definition = $container->getDefinition(Sender::class);
        $definition->replaceArgument(2, $config['api_base_path']);

        $definition = $container->getDefinition(Signer::class);
        $definition->replaceArgument(0, $config['pub_key']);
        $definition->replaceArgument(1, $config['priv_key']);
    }
}
