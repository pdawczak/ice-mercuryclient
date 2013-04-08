<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\CertificateAndDiplomaThreeInstalments;

class CertificateAndDiplomaThreeInstalmentsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreated()
    {
        $now = new \DateTime();
        $instalmentTwoDate = new \DateTime('2013-02-01');
        $instalmentThreeDate = new \DateTime('2013-04-01');

        $plan = new CertificateAndDiplomaThreeInstalments();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 1000);

        $this->assertCount(3, $receivables);

        $firstInstalment = $receivables[0];
        $this->assertEquals(340, $firstInstalment->getAmount());
        $this->assertEquals($now, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(330, $secondInstalment->getAmount());
        $this->assertEquals($instalmentTwoDate, $secondInstalment->getDueDate());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(330, $thirdInstalment->getAmount());
        $this->assertEquals($instalmentThreeDate, $thirdInstalment->getDueDate());
    }
}
