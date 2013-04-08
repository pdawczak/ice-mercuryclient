<?php

namespace Ice\MercuryClientBundle\Tests\Service;

use Ice\MercuryClientBundle\Service\PaymentPlanManager;

class PaymentPlanManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testValidPaymentPlanCodeReturnsPaymentPlan()
    {
        $manager = new PaymentPlanManager();
        $plan = $manager->getPaymentPlan('ResidentialRegistrationFee');
        $this->assertInstanceOf('Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee', $plan);

        $plan = $manager->getPaymentPlan('AdvancedDiplomaSixInstalments', '1315November');
        $this->assertInstanceOf('Ice\MercuryClientBundle\PaymentPlan\AdvancedDiplomaSixInstalments1315November', $plan);
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
