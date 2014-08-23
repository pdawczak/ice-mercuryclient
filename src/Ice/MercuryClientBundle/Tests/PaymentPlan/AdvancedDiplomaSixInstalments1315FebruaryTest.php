<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1315February;

class AdvancedDiplomaSixInstalments1315FebruaryTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreated()
    {
        $instalmentTwoDate = new \DateTime('2014-02-01');
        $instalmentThreeDate = new \DateTime('2014-05-01');
        $instalmentFourDate = new \DateTime('2014-11-01');
        $instalmentFiveDate = new \DateTime('2015-02-01');
        $instalmentSixDate = new \DateTime('2015-05-01');

        $plan = new TwoYearSixInstalments1315February();
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
}
