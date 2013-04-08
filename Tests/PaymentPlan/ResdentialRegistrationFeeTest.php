<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee;

class PaymentPlanServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreated()
    {
        $now = new \DateTime();
        $courseStartDate = new \DateTime("+6 week");
        $twoWeeksBeforeCourseStart = new \DateTime("+4 week");

        $plan = new ResidentialRegistrationFee();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables($courseStartDate, 1000);

        $this->assertCount(2, $receivables);

        $firstInstallment = $receivables[0];
        $this->assertEquals(150, $firstInstallment->getAmount());
        $this->assertEquals($now, $firstInstallment->getDueDate());

        $secondInstallment = $receivables[1];
        $this->assertEquals(850, $secondInstallment->getAmount());
        $this->assertEquals($twoWeeksBeforeCourseStart, $secondInstallment->getDueDate());

    }
}
