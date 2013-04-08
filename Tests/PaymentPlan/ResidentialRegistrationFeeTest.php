<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee;

class ResidentialRegistrationFeeTest extends \PHPUnit_Framework_TestCase
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

        $firstInstalment = $receivables[0];
        $this->assertEquals(150, $firstInstalment->getAmount());
        $this->assertEquals($now, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(850, $secondInstalment->getAmount());
        $this->assertEquals($twoWeeksBeforeCourseStart, $secondInstalment->getDueDate());

    }
}
