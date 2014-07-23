<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1416Mst;

class TwoYearSixInstalments1416MstTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreated()
    {
        $instalmentTwoDate = new \DateTime('2015-01-01');
        $instalmentThreeDate = new \DateTime('2015-04-01');
        $instalmentFourDate = new \DateTime('2015-09-01');
        $instalmentFiveDate = new \DateTime('2016-01-01');
        $instalmentSixDate = new \DateTime('2016-04-01');

        $plan = new TwoYearSixInstalments1416Mst();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 220000);

        $this->assertCount(6, $receivables);

        $firstInstalment = $receivables[0];
        $this->assertEquals(37400, $firstInstalment->getAmount());
        $this->assertEquals(null, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(37400, $secondInstalment->getAmount());
        $this->assertEquals($instalmentTwoDate, $secondInstalment->getDueDate());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(35200, $thirdInstalment->getAmount());
        $this->assertEquals($instalmentThreeDate, $thirdInstalment->getDueDate());

        $fourthInstalment = $receivables[3];
        $this->assertEquals(37400, $fourthInstalment->getAmount());
        $this->assertEquals($instalmentFourDate, $fourthInstalment->getDueDate());

        $fifthInstalment = $receivables[4];
        $this->assertEquals(37400, $fifthInstalment->getAmount());
        $this->assertEquals($instalmentFiveDate, $fifthInstalment->getDueDate());

        $sixthInstalment = $receivables[5];
        $this->assertEquals(35200, $sixthInstalment->getAmount());
        $this->assertEquals($instalmentSixDate, $sixthInstalment->getDueDate());
    }

    public function testCorrectReceivablesCreated10kBursary()
    {
        $instalmentTwoDate = new \DateTime('2015-01-01');
        $instalmentThreeDate = new \DateTime('2015-04-01');
        $instalmentFourDate = new \DateTime('2015-09-01');
        $instalmentFiveDate = new \DateTime('2016-01-01');
        $instalmentSixDate = new \DateTime('2016-04-01');

        $plan = new TwoYearSixInstalments1416Mst();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 875000);

        $this->assertCount(6, $receivables);

        $firstInstalment = $receivables[0];
        $this->assertEquals(170000, $firstInstalment->getAmount());
        $this->assertEquals(null, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(170000, $secondInstalment->getAmount());
        $this->assertEquals($instalmentTwoDate, $secondInstalment->getDueDate());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(160000, $thirdInstalment->getAmount());
        $this->assertEquals($instalmentThreeDate, $thirdInstalment->getDueDate());

        $fourthInstalment = $receivables[3];
        $this->assertEquals(170000, $fourthInstalment->getAmount());
        $this->assertEquals($instalmentFourDate, $fourthInstalment->getDueDate());

        $fifthInstalment = $receivables[4];
        $this->assertEquals(170000, $fifthInstalment->getAmount());
        $this->assertEquals($instalmentFiveDate, $fifthInstalment->getDueDate());

        $sixthInstalment = $receivables[5];
        $this->assertEquals(35000, $sixthInstalment->getAmount());
        $this->assertEquals($instalmentSixDate, $sixthInstalment->getDueDate());
    }

    public function testCorrectReceivablesCreated20kBursary()
    {
        $instalmentTwoDate = new \DateTime('2015-01-01');
        $instalmentThreeDate = new \DateTime('2015-04-01');
        $instalmentFourDate = new \DateTime('2015-09-01');
        $instalmentFiveDate = new \DateTime('2016-01-01');
        $instalmentSixDate = new \DateTime('2016-04-01');

        $plan = new TwoYearSixInstalments1416Mst();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 1875000);

        $this->assertCount(6, $receivables);

        $firstInstalment = $receivables[0];
        $this->assertEquals(340000, $firstInstalment->getAmount());
        $this->assertEquals(null, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(340000, $secondInstalment->getAmount());
        $this->assertEquals($instalmentTwoDate, $secondInstalment->getDueDate());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(320000, $thirdInstalment->getAmount());
        $this->assertEquals($instalmentThreeDate, $thirdInstalment->getDueDate());

        $fourthInstalment = $receivables[3];
        $this->assertEquals(340000, $fourthInstalment->getAmount());
        $this->assertEquals($instalmentFourDate, $fourthInstalment->getDueDate());

        $fifthInstalment = $receivables[4];
        $this->assertEquals(340000, $fifthInstalment->getAmount());
        $this->assertEquals($instalmentFiveDate, $fifthInstalment->getDueDate());

        $sixthInstalment = $receivables[5];
        $this->assertEquals(195000, $sixthInstalment->getAmount());
        $this->assertEquals($instalmentSixDate, $sixthInstalment->getDueDate());
    }
}
