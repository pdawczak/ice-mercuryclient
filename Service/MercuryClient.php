<?php

namespace Ice\MercuryClientBundle\Service;

use Guzzle\Service\Client;
use Doctrine\Common\Collections\ArrayCollection;

class MercuryClient
{
    /**
     * @var MercuryRestClient
     */
    private $restClient;

    /**
     * @param \Ice\MercuryClientBundle\Service\MercuryRestClient $restClient
     * @return MercuryClient
     */
    public function setRestClient($restClient)
    {
        $this->restClient = $restClient;
        return $this;
    }

    /**
     * @return \Ice\MercuryClientBundle\Service\MercuryRestClient
     */
    public function getRestClient()
    {
        return $this->restClient;
    }

    /**
     * @param int $id
     * @return \Ice\MercuryClientBundle\Entity\Order
     */
    public function findOrderById($id){
        return $this->getRestClient()->getCommand('GetOrder', array('id'=>$id))->execute();
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\Order[]|ArrayCollection
     */
    public function findAllOrders(){
        return $this->getRestClient()->getCommand('GetOrders')->execute();
    }


    /**
     * @param int $id
     * @return \Ice\MercuryClientBundle\Entity\SuborderGroup
     */
    public function findSuborderGroupById($id){
        return $this->getRestClient()->getCommand('GetSuborderGroup', array('id'=>$id))->execute();
    }
}