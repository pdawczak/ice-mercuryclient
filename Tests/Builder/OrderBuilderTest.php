<?php

namespace Ice\MercuryClientBundle\Tests\Builder;

use Doctrine\Common\Collections\ArrayCollection;
use Ice\MercuryClientBundle\Builder\OrderBuilder;
use Ice\MercuryClientBundle\Entity\LineItem;
use Ice\MercuryClientBundle\Entity\Suborder;
use Ice\MercuryClientBundle\PaymentPlan\AdvancedDiplomaSixInstalments1315February;
use Ice\MinervaClientBundle\Entity\Booking;
use Ice\MinervaClientBundle\Entity\BookingItem as MinervaBookingItem;
use Ice\VeritasClientBundle\Entity\BookingItem as VeritasBookingItem;
use Ice\VeritasClientBundle\Entity\Course;
use Ice\JanusClientBundle\Entity\User;
use Ice\MinervaClientBundle\Entity\AcademicInformation;

class OrderBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectFinanceCodeSetInSuborder()
    {
        $itemCode = 'TESTCODE';
        $itemFinanceCode = 'AAAA.BBBB.CCCC.DDDD';

        $veritasBookingItem = $this->getMockVeritasBookingItem($itemCode, $itemFinanceCode);
        $veritasCourse = $this->getMockVeritasCourse(array($veritasBookingItem));
        $minervaBookingItem = $this->getMockMinervaBookingItem($itemCode);
        $academicInformation = $this->getMockAcademicInformation(1, 'rh1');
        $minervaBooking = $this->getMockMinervaBooking(array($minervaBookingItem), $academicInformation);
        $janusUser = $this->getMockDelegate();

        $builder = new OrderBuilder();

        $order = $builder->addNewBooking(
            $minervaBooking,
            new AdvancedDiplomaSixInstalments1315February(),
            $veritasCourse,
            $janusUser
        );

        /** @var Suborder $suborder */
        $suborder = $order->getOrder()->getSuborders()->first();

        /** @var LineItem $lineItem */
        $lineItem = $suborder->getLineItems()->first();
        $this->assertEquals('AAAA.BBBB.CCCC.DDDD', $lineItem->getCostCentre());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownIfMinervaBookingItemIsNotAvailableInVeritasCourse()
    {
        $itemFinanceCode = 'AAAA.BBBB.CCCC.DDDD';

        $veritasBookingItem = $this->getMockVeritasBookingItem('TESTITEM', $itemFinanceCode);
        $veritasCourse = $this->getMockVeritasCourse(array($veritasBookingItem));
        $minervaBookingItem = $this->getMockMinervaBookingItem('DOESNOTEXIST');
        $academicInformation = $this->getMockAcademicInformation(1, 'rh1');
        $minervaBooking = $this->getMockMinervaBooking(array($minervaBookingItem), $academicInformation);

        $builder = new OrderBuilder();
        $builder->addNewBooking($minervaBooking, new AdvancedDiplomaSixInstalments1315February(), $veritasCourse);
    }

    /**
     * @param $code
     * @param $financeCode
     *
     * @return VeritasBookingItem|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockVeritasBookingItem($code, $financeCode)
    {
        $veritasBookingItem = $this->getMock('Ice\\VeritasClientBundle\\Entity\\BookingItem');
        $veritasBookingItem
            ->expects($this->once())
            ->method('getCode')
            ->will($this->returnValue($code));

        $veritasBookingItem
            ->expects($this->any())
            ->method('getFinanceCode')
            ->will($this->returnValue($financeCode));

        return $veritasBookingItem;
    }

    /**
     * @param array     $veritasBookingItems
     *
     * @param \DateTime $startDate
     *
     * @return Course|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockVeritasCourse(array $veritasBookingItems, \DateTime $startDate = null)
    {
        if (!$startDate) {
            $startDate = new \DateTime();
        }

        $veritasCourse = $this->getMock('Ice\\VeritasClientBundle\\Entity\\Course');
        $veritasCourse
            ->expects($this->once())
            ->method('getBookingItems')
            ->will($this->returnValue(new ArrayCollection($veritasBookingItems)));

        $veritasCourse
            ->expects($this->once())
            ->method('getStartDate')
            ->will($this->returnValue($startDate));

        return $veritasCourse;
    }

    /**
     * @param $itemCode
     *
     * @return MinervaBookingItem|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockMinervaBookingItem($itemCode)
    {
        $minervaBookingItem = $this->getMock('Ice\\MinervaClientBundle\\Entity\\BookingItem');
        $minervaBookingItem
            ->expects($this->any())
            ->method('getCode')
            ->will($this->returnValue($itemCode));
        return $minervaBookingItem;
    }

    /**
     * @param array $minervaBookingItems
     * @param AcademicInformation $academicInformation
     * @return Booking|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockMinervaBooking(array $minervaBookingItems, $academicInformation)
    {
        $minervaBooking = $this->getMock('Ice\\MinervaClientBundle\\Entity\\Booking');
        $minervaBooking
            ->expects($this->once())
            ->method('getBookingItems')
            ->will($this->returnValue($minervaBookingItems));

        $minervaBooking
            ->expects($this->any())
            ->method('getAcademicInformation')
            ->will($this->returnValue($academicInformation));

        return $minervaBooking;
    }

    /**
     * @return User|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockDelegate()
    {
        $user = $this->getMock('Ice\\JanusClientBundle\\Entity\\User');

        $user
            ->expects($this->once())
            ->method('getFirstNames')
            ->will($this->returnValue('Rob'));

        $user
            ->expects($this->once())
            ->method('getLastNames')
            ->will($this->returnValue('Hogan'));

        return $user;
    }

    /**
     * @param $courseId
     * @param $iceId
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAcademicInformation($courseId, $iceId)
    {
        $ai = $this->getMock('Ice\\MinervaClientBundle\\Entity\\AcademicInformation');

        $ai
            ->expects($this->any())
            ->method('getCourseId')
            ->will($this->returnValue($courseId));

        $ai
            ->expects($this->any())
            ->method('getIceId')
            ->will($this->returnValue($iceId));

        return $ai;
    }
}
