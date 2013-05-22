<?php
namespace Ice\MercuryClientBundle\Builder;

use Ice\JanusClientBundle\Entity\User;
use Ice\MercuryClientBundle\Entity\LineItem;
use Ice\MercuryClientBundle\Entity\Order;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;
use Ice\MercuryClientBundle\Entity\Suborder;
use Ice\MercuryClientBundle\Entity\PaymentGroup;
use Ice\MinervaClientBundle\Entity\Booking;
use Ice\VeritasClientBundle\Entity\BookingItem;
use Ice\VeritasClientBundle\Entity\Course;
use Ice\VeritasClientBundle\Service\VeritasClient;
use Ice\JanusClientBundle\Service\JanusClient;


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
     * @var JanusClient
     */
    protected $janusClient;

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
     * @param \Ice\JanusClientBundle\Service\JanusClient $janusClient
     * @return OrderBuilder
     */
    public function setJanusClient($janusClient)
    {
        $this->janusClient = $janusClient;
        return $this;
    }

    /**
     * @return \Ice\JanusClientBundle\Service\JanusClient
     */
    public function getJanusClient()
    {
        return $this->janusClient;
    }

    /**
     * @param User $account
     * @return OrderBuilder
     */
    public function setCustomerByAccount(User $account)
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
     * @param Booking              $booking
     * @param PaymentPlanInterface $paymentPlan
     * @param Course               $course
     *
     * @throws \LogicException
     * @throws \RuntimeException
     * @return OrderBuilder
     */
    public function addNewBooking(Booking $booking, PaymentPlanInterface $paymentPlan, Course $course = null, User $delegate = null)
    {
        $suborder = new Suborder();
        $paymentGroup = new PaymentGroup();

        if (!$course && !$this->getVeritasClient()) {
            throw new \LogicException("Course must be given or veritas client must be set before a booking can be added");
        }
        if (!$course) {
            $course = $this->getVeritasClient()->getCourse($booking->getAcademicInformation()->getCourseId());
        }

        if (!$delegate && $this->getJanusClient()) {
            try {
                $delegate = $this->getJanusClient()->getUser($booking->getAcademicInformation()->getIceId());
            } catch (\Exception $e) {
                //No big deal - Mercury will be missing some delegate attributes.
                $delegate = null;
            }
        }

        $receivables = $paymentPlan->getReceivables(
            $course->getStartDate(),
            $booking->getBookingTotalPriceInPence()
        );

        $suborder->setNewReceivables($receivables);

        if ($receivables) {
            $paymentGroup->setAttributeByNameAndValue('agreed_payment_method', $receivables[0]->getMethod());
        }

        $paymentGroup
            ->setAttributeByNameAndValue('booking_id', $booking->getId())
            ->setAttributeByNameAndValue('delegate_ice_id', $booking->getAcademicInformation()->getIceId())
            ->setAttributeByNameAndValue('course_id', $booking->getAcademicInformation()->getCourseId())
        ;

        if ($delegate) {
            $paymentGroup
                ->setAttributeByNameAndValue('delegate_first_names', $delegate->getFirstNames())
                ->setAttributeByNameAndValue('delegate_last_names', $delegate->getLastNames());
        }


        $suborder
            ->setDescription($course->getTitle())
            ->setExternalId($booking->getSuborderGroup())
            ->setPaymentGroup($paymentGroup)
            ->setPaymentPlanDescription($paymentPlan->getShortDescription());

        foreach ($booking->getBookingItems() as $item) {
            /** @var BookingItem $matchingCourseItem */
            $matchingCourseItem = $course->getBookingItems()->filter(function (BookingItem $courseItem) use ($item) {
                return $courseItem->getCode() === $item->getCode();
            })->first();

            if (!$matchingCourseItem) {
                throw new \RuntimeException("Could not find a Course BookingItem that matches the Booking BookingItem.");
            }

            $financeCode = $matchingCourseItem->getFinanceCode();

            $suborder->addLineItem(
                (new LineItem())
                    ->setDescription($item->getDescription())
                    ->setAmount($item->getPrice())
                    ->setExternalId($item->getCode())
                    ->setCostCentre($financeCode) // Finance code is what is needed. Cost centre will be renamed to finance code in Mercury.
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
