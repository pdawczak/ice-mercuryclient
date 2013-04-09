<?php

namespace Ice\MercuryClientBundle\Tests\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\PaymentPlan\FullAmountNow;

class FullAmountNowTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectReceivablesCreated()
    {
        $now = new \DateTime();

        $plan = new FullAmountNow();
        /** @var $receivables Receivable[] */
        $receivables = $plan->getReceivables(new \DateTime(), 1000);

        $this->assertCount(1, $receivables);

        $instalment = $receivables[0];
        $this->assertEquals(1000, $instalment->getAmount());
        $this->assertEquals($now, $instalment->getDueDate());
    }
}
