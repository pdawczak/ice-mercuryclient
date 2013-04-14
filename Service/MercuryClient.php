<?php

namespace Ice\MercuryClientBundle\Service;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Service\Client;
use Doctrine\Common\Collections\ArrayCollection;
use Guzzle\Service\Command\DefaultRequestSerializer;
use Ice\MercuryClientBundle\Builder\NewOrderBuilder;
use Ice\MercuryClientBundle\Entity\Order;
use Guzzle\Service\Command\OperationCommand;

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
    public function findOrderById($id)
    {
        return $this->getRestClient()->getCommand('GetOrder', array('id' => $id))->execute();
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\Order[]|ArrayCollection
     */
    public function findAllOrders()
    {
        return $this->getRestClient()->getCommand('GetOrders')->execute();
    }

    /**
     * @return NewOrderBuilder
     */
    public function getNewOrderBuilder()
    {
        return new NewOrderBuilder();
    }

    /**
     * @param Order $order
     * @return Order
     */
    public function createOrder(Order $order)
    {
        try {
            /** @var $command OperationCommand */
            $command = $this->getRestClient()->getCommand('CreateOrder', array('order' => $order));
            return $command->execute();
        } catch (BadResponseException $e) {
            //TODO: Translate into a usable error
            throw $e;
        }
    }


    /**
     * @param int $id
     * @return \Ice\MercuryClientBundle\Entity\SuborderGroup
     */
    public function findSuborderGroupById($id)
    {
        return $this->getRestClient()->getCommand('GetSuborderGroup', array('id' => $id))->execute();
    }
}