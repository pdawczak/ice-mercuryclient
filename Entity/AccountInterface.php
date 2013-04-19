<?php
namespace Ice\MercuryClientBundle\Entity;

interface AccountInterface
{
    /**
     * Username (Ice ID)
     *
     * @return string
     */
    public function getUsername();

    /**
     * Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * First names
     *
     * @return string
     */
    public function getFirstNames();

    /**
     * Middle names
     *
     * @return string
     */
    public function getMiddleNames();

    /**
     * Last names
     *
     * @return string
     */
    public function getLastNames();

    /**
     * Email address
     *
     * @return string
     */
    public function getEmail();
}