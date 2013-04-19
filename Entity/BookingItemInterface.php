<?php
namespace Ice\MercuryClientBundle\Entity;

interface BookingItemInterface {
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