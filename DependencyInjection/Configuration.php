<?php

namespace Ice\MercuryClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ice_mercury_client');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->scalarNode('base_url')
                    ->info('Base URL for the API.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('username')
                    ->info('Username to authenticate against the API.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('password')
                    ->info('Password to authenticate against the API.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('gateway_secret')
                    ->info('Password used to sign requests to the payment gateway.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('gateway_account')
                    ->info('The SecureTrading site reference to use. Test accounts are prefixed test_')
                    ->defaultValue('test_uniofcam45561')
                    ->end()
                ->scalarNode('gateway_root_url')
                    ->info('The URL for the gateway iframe')
                    ->defaultValue('https://payments.securetrading.net/process/payments/choice')
                    ->end()
                ->scalarNode('gateway_method')
                    ->info('Either MOTO (for admin staff use) or ECOM (for cardholder use)')
                    ->defaultValue('MOTO')
                    ->end()
            ->end();

        return $treeBuilder;
    }
}