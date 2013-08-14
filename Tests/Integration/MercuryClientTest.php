<?php

namespace Ice\MercuryClientBundle\Tests\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Ice\MercuryClientBundle\Tests\Util\WebTestCase;

use Ice\MercuryClientBundle\Service\MercuryClient;
use Ice\MinervaClientBundle\Entity\AcademicInformation;
use Ice\MinervaClientBundle\Entity\Booking;
use Ice\MercuryClientBundle\Service\PaymentPlanService;
use Ice\MinervaClientBundle\Entity\BookingItem;
use Ice\MinervaClientBundle\Entity\Category;
use Ice\VeritasClientBundle\Entity\Course;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

use Guzzle\Common\Event;
use Guzzle\Http\Message\EntityEnclosingRequest;

class MercuryClientTest extends WebTestCase
{
    /**
     * @return MercuryClient
     */
    protected function getMercuryClient()
    {
        /** @var $client MercuryClient */
        static $client;
        if (isset($client)) return $client;

        $client = $this->getContainer()->get('mercury.client');

        return $client;
    }

    /**
     * @param $code
     * @param $financeCode
     * @param bool $inStock
     * @return \Ice\VeritasClientBundle\Entity\BookingItem|MockObject
     */
    private function getMockCourseBookingItem($code, $financeCode, $inStock = true)
    {
        /** @var \Ice\VeritasClientBundle\Entity\BookingItem | MockObject $bookingItem */
        $bookingItem = $this->getMock('Ice\VeritasClientBundle\Entity\BookingItem',
            array('getCode', 'getFinanceCode', 'isInStock')
        );

        $bookingItem->expects($this->any())
            ->method('getCode')
            ->will($this->returnValue($code));

        $bookingItem->expects($this->any())
            ->method('getFinanceCode')
            ->will($this->returnValue($financeCode));

        $bookingItem->expects($this->any())
            ->method('isInStock')
            ->will($this->returnValue($inStock));

        return $bookingItem;
    }

    /**
     * @param $code
     * @return \Ice\MinervaClientBundle\Entity\BookingItem|MockObject
     */
    private function getMockBookingBookingItem($code)
    {
        /** @var \Ice\MinervaClientBundle\Entity\BookingItem | MockObject $bookingItem */
        $bookingItem = $this->getMock('Ice\MinervaClientBundle\Entity\BookingItem',
            array('getCode')
        );

        $bookingItem->expects($this->any())
            ->method('getCode')
            ->will($this->returnValue($code));

        return $bookingItem;
    }

    /**
     * @return MockObject|\Ice\VeritasClientBundle\Entity\Course
     */
    private function getMockCourse()
    {
        /** @var \Ice\VeritasClientBundle\Entity\Course | MockObject $course */
        $course = $this->getMock('Ice\VeritasClientBundle\Entity\Course',
            array('getBookingItems')
        );

        $course->expects($this->any())
            ->method('getBookingItems')
            ->will($this->returnValue(new ArrayCollection([
                $this->getMockCourseBookingItem('TESTCODE1', 'TESTFINANCECODE1'),
                $this->getMockCourseBookingItem('TESTCODE2', 'TESTFINANCECODE2')
            ])));

        return $course;
    }

    /**
     * @group internet
     */
    public function testValidWebOrderProcess()
    {
        /** @var $client MercuryClient */
        $client = $this->getMercuryClient();

        /** @var $planService PaymentPlanService */
        $planService = $this->getContainer()->get('mercury.payment_plans');

        $builder = $client->getNewOrderBuilder();

        $course = $this->getMockCourse();

        $course->setCostCentre('TEST');
        $course->setStartDate(new \DateTime());

        $builder->addNewBooking(
            (new Booking())
                ->setAcademicInformation(
                    (new AcademicInformation())
                        ->setCourseId(1000)
                )
                ->setBookingItems(array(
                    $this->getMockBookingBookingItem('TESTCODE1')
                        ->setDescription('Some thing')
                        ->setPrice(1000)
                        ->setCategory((new Category())->setId(Category::TUITION_CATEGORY))
                ,
                    $this->getMockBookingBookingItem('TESTCODE2')
                        ->setDescription('Some less expensive thing')
                        ->setPrice(500)
                        ->setCategory((new Category())->setId(Category::TUITION_CATEGORY))
                ))
            ,
            $planService->getPaymentPlan('FullAmountNow', '1'),
            $course
        );

        $order = $builder->getOrder();
        $order->setIceId('test');

        $order->setCreated(new \DateTime('2013-01-01'));
        $order->setIceId('rh1');

        $newOrder = $client->createOrder($order);

        $this->assertEquals(
            (new \DateTime('2013-01-01'))->format('Y-m-d'),
            $newOrder->getCreated()->format('Y-m-d'),
            "New order date not correctly set"
        );

        $this->assertEquals(
            1,
            $newOrder->getSuborders()->count(),
            "Order should contain one suborder"
        );

        $this->assertEquals(
            2,
            $newOrder->getSuborders()->first()->getLineItems()->count(),
            "Suborder should contain two line items"
        );

        $transactionRequest = $client->requestOutstandingOnlineTransactionsByOrder($newOrder);

        $transaction = $client->createTransaction($client->getNewTransactionBuilder()->setTransactionRequest($transactionRequest)->getTransaction());


        $transactionRequestAgain = $client->getTransactionRequestById($transactionRequest->getId());

        echo $transactionRequestAgain->getId();
    }
}