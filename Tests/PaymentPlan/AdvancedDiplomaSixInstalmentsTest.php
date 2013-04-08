<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\AdvancedDiplomaSixInstalments;

class AdvancedDiplomaSixInstalmentsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreated()
    {
        $now = new \DateTime();
        $instalmentTwoDate = new \DateTime('2013-11-01');
        $instalmentThreeDate = new \DateTime('2014-02-01');
        $instalmentFourDate = new \DateTime('2014-08-01');
        $instalmentFiveDate = new \DateTime('2014-11-01');
        $instalmentSixDate = new \DateTime('2015-02-01');

        $plan = new AdvancedDiplomaSixInstalments();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 1000);

        $this->assertCount(6, $receivables);

        $firstInstalment = $receivables[0];
        $this->assertEquals(170, $firstInstalment->getAmount());
        $this->assertEquals($now, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(160, $secondInstalment->getAmount());
        $this->assertEquals($instalmentTwoDate, $secondInstalment->getDueDate());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(160, $thirdInstalment->getAmount());
        $this->assertEquals($instalmentThreeDate, $thirdInstalment->getDueDate());

        $fourthInstalment = $receivables[3];
        $this->assertEquals(160, $fourthInstalment->getAmount());
        $this->assertEquals($instalmentFourDate, $fourthInstalment->getDueDate());

        $fifthInstalment = $receivables[4];
        $this->assertEquals(160, $fifthInstalment->getAmount());
        $this->assertEquals($instalmentFiveDate, $fifthInstalment->getDueDate());

        $sixthInstalment = $receivables[5];
        $this->assertEquals(160, $sixthInstalment->getAmount());
        $this->assertEquals($instalmentSixDate, $sixthInstalment->getDueDate());
    }
}
