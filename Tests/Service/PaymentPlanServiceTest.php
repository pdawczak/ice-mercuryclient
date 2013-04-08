<?php

namespace Ice\MercuryClientBundle\Tests\Service;

use Ice\MercuryClientBundle\Service\PaymentPlanService;

class PaymentPlanServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetReceivableReturnsAnArrayOfReceivables()
    {
        $service = new PaymentPlanService();
        $receivables = $service->getReceivables('residentialRegistrationFee', new \DateTime(), 1000);
        $this->assertCount(2, $receivables);
    }
}
