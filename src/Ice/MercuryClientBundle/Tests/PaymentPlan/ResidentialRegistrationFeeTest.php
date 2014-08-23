<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee;

class ResidentialRegistrationFeeTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreatedForNonAccommodationBooking()
    {
        $courseStartDate = new \DateTime("+6 week");
        $twoWeeksBeforeCourseStart = new \DateTime("+4 week");

        $plan = new ResidentialRegistrationFee();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables($courseStartDate, 24000);

        $this->assertCount(2, $receivables);

        $firstInstalment = $receivables[0];
        $this->assertEquals(3600, $firstInstalment->getAmount());
        $this->assertEquals(null, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(20400, $secondInstalment->getAmount());
        $this->assertEquals($twoWeeksBeforeCourseStart, $secondInstalment->getDueDate());

    }

    public function testCorrectReceivableAmountsCreatedForAccommodationBooking()
    {
        $plan = new ResidentialRegistrationFee();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 35000);

        $firstInstalment = $receivables[0];
        $this->assertEquals(5250, $firstInstalment->getAmount());

        $secondInstalment = $receivables[1];
        $this->assertEquals(29750, $secondInstalment->getAmount());
    }

    public function testCorrectReceivableAmountsCreatedForAccommodationBookingWithBursary()
    {
        $plan = new ResidentialRegistrationFee();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 25000);

        $firstInstalment = $receivables[0];
        $this->assertEquals(3750, $firstInstalment->getAmount());

        $secondInstalment = $receivables[1];
        $this->assertEquals(21250, $secondInstalment->getAmount());
    }
}
