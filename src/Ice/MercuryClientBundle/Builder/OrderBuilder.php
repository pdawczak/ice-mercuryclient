<?php
namespace Ice\MercuryClientBundle\Builder;

use Doctrine\Common\Collections\ArrayCollection;
use Ice\JanusClientBundle\Entity\User;
use Ice\MercuryClientBundle\Entity\AllocationTarget;
use Ice\MercuryClientBundle\Entity\CustomerInterface;
use Ice\MercuryClientBundle\Entity\LineItem;
use Ice\MercuryClientBundle\Entity\Order;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\Suborder;
use Ice\MercuryClientBundle\Entity\PaymentGroup;
use Ice\MercuryClientBundle\Exception\CapacityException;
use Ice\MercuryClientBundle\Builder\ProposedSuborder;
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

    public function setCustomer(CustomerInterface $customer)
    {
        $this->order
            ->setIceId($customer->getIceId())
            ->setCustomerTitle($customer->getTitle())
            ->setCustomerFirstNames($customer->getFirstNames())
            ->setCustomerMiddleNames($customer->getMiddleNames())
            ->setCustomerLastNames($customer->getLastNames())
            ->setCustomerEmail($customer->getEmail())
            ->setCustomerTelephone($customer->getTelephone())
            ->setCustomerMobile($customer->getMobile())
            ->setCustomerAddress1($customer->getAddress1())
            ->setCustomerAddress2($customer->getAddress2())
            ->setCustomerAddress3($customer->getAddress3())
            ->setCustomerAddress4($customer->getAddress4())
            ->setCustomerTown($customer->getTown())
            ->setCustomerCounty($customer->getCounty())
            ->setCustomerPostcode($customer->getPostcode())
            ->setCustomerCountry($customer->getCountry());

        return $this;
    }

    /**
     * @param Booking $booking
     * @param PaymentPlanInterface $paymentPlan
     * @param Course $course
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
            ->setAttributeByNameAndValue('course_id', $booking->getAcademicInformation()->getCourseId());

        $paymentGroup->setExternalId($booking->getSuborderGroup());

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

            //Don't tell Mercury about booking items that have no value
            if ($item->getPrice() === 0) {
                continue;
            }

            /** @var BookingItem $matchingCourseItem */
            $matchingCourseItem = $course->getBookingItems()->filter(function (BookingItem $courseItem) use ($item) {
                return $courseItem->getCode() === $item->getCode();
            })->first();

            if (!$matchingCourseItem) {
                throw new \RuntimeException(sprintf("There is no valid course booking item that has the code \"%s\". The booking will need to be manually modified in the database before it can be paid for.", $item->getCode()));
            }

            //Check that all items have capacity available
            if (!$booking->isAllocated()) {
                if (!$matchingCourseItem->isInStock()) {
                    $e = (new CapacityException())
                        ->setBooking($booking)
                        ->setBookingItem($item)
                        ->setCourseItem($matchingCourseItem);
                    throw $e;
                }
            }

            $financeCode = $matchingCourseItem->getFinanceCode();

            $allocationTargets = [];

            if ($item->getCategory()->isDiscount()) {
                foreach($booking->getBookingItems() as $innerItem) {
                    if ($innerItem->getCategory()->isTuition()) {

                        /** @var BookingItem $innerMatchingCourseItem */
                        $innerMatchingCourseItem = $course->getBookingItems()->filter(function (BookingItem $courseItem) use ($innerItem) {
                            return $courseItem->getCode() === $innerItem->getCode();
                        })->first();

                        $allocationTargets[] = (new AllocationTarget())
                            ->setFinanceCode($innerMatchingCourseItem->getFinanceCode())
                            ->setStrategy(AllocationTarget::STRATEGY_NEXT_PAYMENT)
                            ->setWeight(1)
                        ;

                        break;
                    }
                }

            }

            $suborder->addLineItem(
                (new LineItem())
                    ->setDescription($item->getDescription())
                    ->setAmount($item->getPrice())
                    ->setExternalId($item->getCode())
                    ->setCostCentre($financeCode) // Finance code is what is needed. Cost centre will be renamed to finance code in Mercury.
                    ->setAllocationTargets($allocationTargets)
            );
        }
        $this->order->addSuborder($suborder);
        return $this;
    }

    /**
     * @param Booking $booking
     * @param PaymentGroup|null $paymentGroup
     * @param Course $course
     * @param User $delegate
     * @param PaymentPlanInterface|null $paymentPlan
     * @return $this
     */
    public function addBooking($booking, $paymentGroup, Course $course, User $delegate, $paymentPlan)
    {
        $suborder = $this->buildSuborder($booking, $paymentGroup, $course, $delegate);

        if ($suborder->getLineItems()->count() > 0) {

            if ($paymentGroup) {
                $newPaymentGroup = new PaymentGroup();
                $newPaymentGroup->setId($paymentGroup->getId());
                $suborder->setPaymentGroup($newPaymentGroup);
            }
            $suborder->setNewReceivables([(new Receivable())
                ->setMethod('ONLINE')
                ->setAmount($suborder->getTotalAmount())]);

            //If this booking is new
            if (!$paymentGroup && $paymentPlan) {
                $receivables = $paymentPlan->getReceivables(
                    $course->getStartDate(),
                    $booking->getBookingTotalPriceInPence()
                );

                $suborder->setNewReceivables($receivables);

                if ($receivables) {
                    $paymentGroup->setAttributeByNameAndValue('agreed_payment_method', $receivables[0]->getMethod());
                }
            }

            $this->order->addSuborder($suborder);
        }
        return $this;
    }

    /**
     * @param $booking
     * @param PaymentGroup | null $paymentGroup
     * @param Course $course
     * @param User $delegate
     * @return ProposedSuborderInterface
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function buildProposedSuborder($booking, $paymentGroup, Course $course = null, User $delegate = null)
    {
        /** @var Booking $booking */

        $suborder = new ProposedSuborder();

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

        $suborder
            ->setExternalId($booking->getReference())
            ->setBooking($booking)
            ->setPaymentGroup($paymentGroup)
        ;

        if (null === $booking->getCancelledDate()) {
            $suborder->setDescription('Amendment to '.$booking->getReference());

            foreach ($booking->getBookingItems() as $item) {

                //Don't tell Mercury about booking items that have no value
                if ($item->getPrice() === 0) {
                    continue;
                }

                /** @var BookingItem $matchingCourseItem */
                $matchingCourseItem = $course->getBookingItems()->filter(function (BookingItem $courseItem) use ($item) {
                    return $courseItem->getCode() === $item->getCode();
                })->first();

                if (!$matchingCourseItem) {
                    throw new \RuntimeException(sprintf("There is no valid course booking item that has the code \"%s\". The booking will need to be manually modified in the database before it can be paid for.", $item->getCode()));
                }

                $financeCode = $matchingCourseItem->getFinanceCode();

                $allocationTargets = [];

                if ($item->getCategory()->isDiscount() && (substr($item->getCode(), 0, 7) === 'BURSARY')) {
                    foreach($booking->getBookingItems() as $innerItem) {
                        if ($innerItem->getCategory()->isTuition()) {

                            /** @var BookingItem $innerMatchingCourseItem */
                            $innerMatchingCourseItem = $course->getBookingItems()->filter(function (BookingItem $courseItem) use ($innerItem) {
                                return $courseItem->getCode() === $innerItem->getCode();
                            })->first();

                            $allocationTargets[] = (new AllocationTarget())
                                ->setFinanceCode($innerMatchingCourseItem->getFinanceCode())
                                ->setStrategy(AllocationTarget::STRATEGY_NEXT_PAYMENT)
                                ->setWeight(1)
                            ;

                            break;
                        }
                    }
                }

                $suborder->addLineItem(
                    (new ProposedLineItem())
                        ->setBookingItemDescription($item->getDescription())
                        ->setLineItemDescription($item->getDescription())
                        ->setItemValue($item->getPrice())
                        ->setLineAmount($item->getPrice())
                        ->setBookingItemCode($item->getCode())
                        ->setFinanceCode($financeCode)
                        ->setAllocationTargets($allocationTargets)
                );
            }
        }

        if($paymentGroup) {
            $this->subtractExistingPaymentGroupFromProposedSuborder($suborder, $paymentGroup);
        }

        return $suborder;
    }

    /**
     * @param \Ice\MercuryClientBundle\Builder\ProposedSuborder $subject
     * @param PaymentGroup $paymentGroup
     */
    private function subtractExistingPaymentGroupFromProposedSuborder(ProposedSuborder $subject, PaymentGroup $paymentGroup)
    {
        $orderedItems = $this->computeOrderedLineItems($paymentGroup, $subject->getExternalId());

        foreach ($orderedItems as $lineItem) {
            if (($existingLineItem = $this->findMatchingProposedLineItemOrNull($lineItem, $subject))) {
                //This item was already on a previous order.
                $subject->removeLineItem($existingLineItem);
            }
            else { //This was ordered before but isn't in the current suborder. Cancel it.
                $newLineItem = new ProposedLineItem();
                $newLineItem->setBookingItemCode($lineItem->getExternalId())
                    ->setFinanceCode($lineItem->getCostCentre())
                    ->setItemValue(-$lineItem->getAmount())
                    ->setBookingItemDescription($lineItem->getDescription())
                ;
                $subject->addLineItem($newLineItem);
            }
        }
    }

    /**
     * @param PaymentGroup $paymentGroup
     * @param string $bookingReference
     * @return \Doctrine\Common\Collections\ArrayCollection | LineItem[]
     */
    private function computeOrderedLineItems(PaymentGroup $paymentGroup, $bookingReference)
    {
        /** @var Suborder[] $suborders */
        $suborders = [];

        //Filter suborders and put them in date order
        foreach ($paymentGroup->getSuborders() as $suborder) {
            if($suborder->getExternalId() === $bookingReference) {
                $suborders[$suborder->getOrder()->getCreated()->format('Y-m-d H:i:s')] = $suborder;
            }
        }
        ksort($suborders);

        //Get the line items ordered
        $lineItems = [];

        foreach ($suborders as $suborder) {
            foreach ($suborder->getLineItems() as $lineItem) {
                if (isset($lineItems[$lineItem->getExternalId()])) {
                    //We've already considered this line item. The new one must be a cancellation
                    if (strpos($lineItem->getDescription(), 'Cancellation of') !== false) {
                        unset($lineItems[$lineItem->getExternalId()]);
                    } else {
                        throw new \Exception("Bad order history");
                    }
                }
                else {
                    //Haven't seen this line item yet - hopefully it isn't a cancellation.
                    if (strpos($lineItem->getDescription(), 'Cancellation of') === false) {
                        $lineItems[$lineItem->getExternalId()] = $lineItem;
                    } else {
                        throw new \Exception("Bad order history.");
                    }
                }
            }
        }

        return new ArrayCollection($lineItems);
    }

    /**
     * @param \Ice\MercuryClientBundle\Entity\LineItem $subject
     * @param \Ice\MercuryClientBundle\Builder\ProposedSuborderInterface $suborder
     * @return ProposedLineItem|null
     */
    private function findMatchingProposedLineItemOrNull(LineItem $subject, ProposedSuborderInterface $suborder)
    {
        foreach ($suborder->getLineItems() as $lineItem) {
            if ($lineItem->getBookingItemCode() === $subject->getExternalId()) {
                return $lineItem;
            }
        }
        return null;
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
