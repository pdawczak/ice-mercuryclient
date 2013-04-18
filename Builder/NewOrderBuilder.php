<?php
namespace Ice\MercuryClientBundle\Builder;

use Ice\JanusClientBundle\Entity\User;
use Ice\MercuryClientBundle\Entity\LineItem;
use Ice\MercuryClientBundle\Entity\Order;
use Ice\MercuryClientBundle\PaymentPlan\AbstractPaymentPlan;
use Ice\MercuryClientBundle\PaymentPlan\PaymentPlanInterface;
use Ice\MinervaClientBundle\Entity\Booking;
use Ice\MercuryClientBundle\Entity\Suborder;
use Ice\MercuryClientBundle\Entity\PaymentGroup;
use Ice\VeritasClientBundle\Service\VeritasClient;
use Ice\VeritasClientBundle\Entity\Course;

class NewOrderBuilder
{
    /**
     * @var Order
     */
    protected $order;

    /** @var VeritasClient */
    protected $veritasClient;

    /**
     * Pass in an existing order entity, if appropriate, otherwise a new one will be created
     *
     * @param Order|null $order
     */
    public function __construct($order = null)
    {
        if (null === $order) {
            $order = new Order();
        }
        $this->order = $order;
    }

    /**
     * @param \Ice\VeritasClientBundle\Service\VeritasClient $veritasClient
     * @return NewOrderBuilder
     */
    public function setVeritasClient($veritasClient)
    {
        $this->veritasClient = $veritasClient;
        return $this;
    }

    /**
     * @return \Ice\VeritasClientBundle\Service\VeritasClient
     */
    public function getVeritasClient()
    {
        return $this->veritasClient;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setCustomerByUser(User $user)
    {
        $this->order->setIceId($user->getUsername());
        $this->order->setCustomerTitle($user->getTitle());
        $this->order->setCustomerFirstNames($user->getFirstNames());
        $this->order->setCustomerMiddleNames($user->getMiddleNames());
        $this->order->setCustomerLastNames($user->getLastNames());
        $this->order->setCustomerEmail($user->getEmail());
        return $this;
    }

    /**
     * @param Booking $booking
     * @param PaymentPlanInterface $paymentPlan
     * @param Course $course
     * @return $this
     * @throws \LogicException
     */
    public function addNewBooking(Booking $booking, PaymentPlanInterface $paymentPlan, Course $course = null)
    {
        $booking->getPaymentGroupId();
        $suborder = new Suborder();
        $paymentGroup = new PaymentGroup();

        if(!$course && !$this->getVeritasClient()){
            throw new \LogicException("Course must be given or veritas client must be set before a booking can be added");
        }
        if(!$course){
            $course = $this->getVeritasClient()->getCourse($booking->getAcademicInformation()->getCourseId());
        }

        $paymentGroup->setReceivables($paymentPlan->getReceivables(
            $course->getStartDate(),
            $booking->getBookingTotalPriceInPence())
        );

        $suborder->setDescription($course->getTitle());
        $suborder->setExternalId('BOOKING:'.$booking->getId());
        $suborder->setPaymentGroup($paymentGroup);
        $suborder->setPaymentPlanDescription($paymentPlan->getShortDescription());

        foreach ($booking->getBookingItems() as $item) {
            $lineItem = new LineItem();
            $lineItem->setDescription($item->getDescription());
            $lineItem->setAmount($item->getPrice());
            $lineItem->setCostCentre($course->getCostCentre());
            $suborder->addLineItem($lineItem);
        }
        $this->order->addSuborder($suborder);
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
