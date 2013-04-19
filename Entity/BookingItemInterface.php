<?php
namespace Ice\MercuryClientBundle\Entity;

interface BookingItemInterface
{
    /**
     * Booking item unique ID
     *
     * @return int
     */
    public function getId();

    /**
     * A line item description
     *
     * @return string
     */
    public function getDescription();

    /**
     * The price of this item in pence
     *
     * @return int
     */
    public function getPrice();
}