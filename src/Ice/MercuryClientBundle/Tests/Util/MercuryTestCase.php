<?php

namespace Ice\MercuryClientBundle\Tests\Util;

use Liip\FunctionalTestBundle\Test\WebTestCase AS BaseWebTestCase;

class MercuryTestCase extends BaseWebTestCase
{
    /**
     * @param array $options
     * @return TestKernel|\Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public static function createKernel(array $options = array())
    {
        return new TestKernel('test', false);
    }
}