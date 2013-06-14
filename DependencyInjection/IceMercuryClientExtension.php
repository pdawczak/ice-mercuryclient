<?php

namespace Ice\MercuryClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IceMercuryClientExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('ice_mercury_client.service_description_path', __DIR__ . '/../Resources/config/client.json');
        $container->setParameter('ice_mercury_client.base_url', $config['base_url']);
        $container->setParameter('ice_mercury_client.username', $config['username']);
        $container->setParameter('ice_mercury_client.password', $config['password']);
        $container->setParameter('ice_mercury_client.gateway_secret', $config['gateway_secret']);
        $container->setParameter('ice_mercury_client.gateway_account', $config['gateway_account']);
        $container->setParameter('ice_mercury_client.gateway_method', $config['gateway_method']);
        $container->setParameter('ice_mercury_client.gateway_root_url', $config['gateway_root_url']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}