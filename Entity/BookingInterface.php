<?php
namespace Ice\MercuryClientBundle\Entity;

interface BookingInterface
{
    /**
     * Booking unique ID
     *
     * @return int
     */
    public function getId();

    /**
     * The total price of all of this booking's line items in pence
     *
     * @return int
     */
    public function getTotalPrice();

    /**
     * ID of the course this booking is currently for
     *
     * @return int
     */
    public function getCourseId();

    /**
     * An array of booking line items
     *
     * @return BookingItemInterface[]
     */
    public function getItems();
}