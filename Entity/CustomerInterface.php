<?php
namespace Ice\MercuryClientBundle\Entity;

interface CustomerInterface {
    public function getIceId();

    public function getTitle();

    public function getFirstNames();

    public function getMiddleNames();

    public function getLastNames();

    public function getEmail();

    public function getTelephone();

    public function getMobile();

    public function getAddress1();

    public function getAddress2();

    public function getAddress3();

    public function getAddress4();

    public function getTown();

    public function getCounty();

    public function getPostcode();

    public function getCountry();

}
