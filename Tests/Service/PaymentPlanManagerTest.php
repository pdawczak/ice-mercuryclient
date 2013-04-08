<?php

namespace Ice\MercuryClientBundle\Tests\Service;

use Ice\MercuryClientBundle\Service\PaymentPlanManager;

class PaymentPlanManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testValidPaymentPlanCodeReturnsPaymentPlan()
    {
        $manager = new PaymentPlanManager();
        $plan = $manager->getPaymentPlan('residentialRegistrationFee');
        $this->assertInstanceOf('Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee', $plan);
    }

    /**
     * @expectedException Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException
     */
    public function testInvalidPaymentPlanCodeThrowsException()
    {
        $manager = new PaymentPlanManager();
        $plan = $manager->getPaymentPlan('invalid');
    }
}
