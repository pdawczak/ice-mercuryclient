<?php
namespace Ice\MercuryClientBundle\Builder;

use Ice\MercuryClientBundle\Entity\AccountInterface;
use Ice\MercuryClientBundle\Entity\LineItem;
use Ice\MercuryClientBundle\Entity\Order;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;
use Ice\MercuryClientBundle\Entity\Suborder;
use Ice\MercuryClientBundle\Entity\PaymentGroup;
use Ice\VeritasClientBundle\Service\VeritasClient;

use Ice\MercuryClientBundle\External\Entity\CourseInterface;
use Ice\MercuryClientBundle\Entity\BookingInterface;
use Ice\MercuryClientBundle\Entity\BookingItemInterface;

class OrderBuilder
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * @var VeritasClient
     */
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
     * @return OrderBuilder
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
     * @param AccountInterface $account
     * @return OrderBuilder
     */
    public function setCustomerByAccount(AccountInterface $account)
    {
        $this->order->setIceId($account->getUsername())
            ->setCustomerTitle($account->getTitle())
            ->setCustomerFirstNames($account->getFirstNames())
            ->setCustomerMiddleNames($account->getMiddleNames())
            ->setCustomerLastNames($account->getLastNames())
            ->setCustomerEmail($account->getEmail());
        return $this;
    }

    /**
     * @param BookingInterface $booking
     * @param PaymentPlanInterface $paymentPlan
     * @param CourseInterface $course
     * @return OrderBuilder
     * @throws \LogicException
     */
    public function addNewBooking(BookingInterface $booking, PaymentPlanInterface $paymentPlan, CourseInterface $course = null)
    {
        $suborder = new Suborder();
        $paymentGroup = new PaymentGroup();

        if (!$course && !$this->getVeritasClient()) {
            throw new \LogicException("Course must be given or veritas client must be set before a booking can be added");
        }
        if (!$course) {
            $course = $this->getVeritasClient()->getCourse($booking->getCourseId());
        }

        $paymentGroup->setReceivables($paymentPlan->getReceivables(
                $course->getStartDate(),
                $booking->getTotalPrice())
        );

        $suborder
            ->setDescription($course->getTitle())
            ->setExternalId('BOOKING:' . $booking->getId())
            ->setPaymentGroup($paymentGroup)
            ->setPaymentPlanDescription($paymentPlan->getShortDescription());

        foreach ($booking->getItems() as $item) {
            $suborder->addLineItem(
                (new LineItem())
                    ->setDescription($item->getDescription())
                    ->setAmount($item->getPrice())
                    ->setExternalId('BOOKINGITEM:' . $item->getId())
                    ->setCostCentre($course->getCostCentre())
            );
        }
        $this->order->addSuborder($suborder);
        return $this;
    }

    /**
     * Set the date this order was created. Only necessary to call this if deliberately creating old orders (eg migration)
     *
     * @param \DateTime $created
     * @return OrderBuilder
     */
    public function setCreatedDate(\DateTime $created)
    {
        $this->order->setCreated($created);
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
