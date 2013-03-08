<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class Order{
    /**
     * @var string
     * @JMS\Type("string")
     */
    private $iceId;
}
