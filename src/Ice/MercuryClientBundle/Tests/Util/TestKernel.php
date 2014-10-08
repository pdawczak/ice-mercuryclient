<?php

namespace Ice\MercuryClientBundle\Tests\Util;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class TestKernel extends Kernel
{
    /**
     * @return array|\Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle(),
            new \Misd\GuzzleBundle\MisdGuzzleBundle(),
            new \Ice\MercuryClientBundle\IceMercuryClientBundle(),
        );
        return $bundles;
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
