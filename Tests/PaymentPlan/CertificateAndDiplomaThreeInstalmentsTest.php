<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\CertificateAndDiplomaThreeInstalments1314;

class CertificateAndDiplomaThreeInstalmentsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreated()
    {
        $instalmentTwoDate = new \DateTime('2013-11-01');
        $instalmentThreeDate = new \DateTime('2014-02-01');

        $plan = new CertificateAndDiplomaThreeInstalments1314();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 1000);

        $this->assertCount(3, $receivables);

        $firstInstalment = $receivables[0];
        $this->assertEquals(340, $firstInstalment->getAmount());
        $this->assertEquals(null, $firstInstalment->getDueDate());

        $secondInstalment = $receivables[1];
        $this->assertEquals(330, $secondInstalment->getAmount());
        $this->assertEquals($instalmentTwoDate, $secondInstalment->getDueDate());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(330, $thirdInstalment->getAmount());
        $this->assertEquals($instalmentThreeDate, $thirdInstalment->getDueDate());
    }

    public function testCorrectReceivablesCreatedForCertificateWithBursary()
    {
        $plan = new CertificateAndDiplomaThreeInstalments1314();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 130000);

        $firstInstalment = $receivables[0];
        $this->assertEquals(44200, $firstInstalment->getAmount());

        $secondInstalment = $receivables[1];
        $this->assertEquals(42900, $secondInstalment->getAmount());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(42900, $thirdInstalment->getAmount());
    }

    public function testCorrectReceivablesCreatedForDiploma()
    {
        $plan = new CertificateAndDiplomaThreeInstalments1314();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 150000);

        $firstInstalment = $receivables[0];
        $this->assertEquals(51000, $firstInstalment->getAmount());

        $secondInstalment = $receivables[1];
        $this->assertEquals(49500, $secondInstalment->getAmount());

        $thirdInstalment = $receivables[2];
        $this->assertEquals(49500, $thirdInstalment->getAmount());
    }
}
