<?php

namespace Ice\MercuryClientBundle\Service;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Service\Client;
use Doctrine\Common\Collections\ArrayCollection;
use Guzzle\Service\Command\DefaultRequestSerializer;
use Ice\MercuryClientBundle\Builder\OrderBuilder;
use Ice\MercuryClientBundle\Builder\TransactionBuilder;
use Ice\MercuryClientBundle\Entity\Order;
use Guzzle\Service\Command\OperationCommand;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\Transaction;
use Ice\MercuryClientBundle\Entity\TransactionRequest;
use Ice\MercuryClientBundle\Entity\TransactionRequestComponent;

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
     * @param string $reference
     * @return \Ice\MercuryClientBundle\Entity\Order
     */
    public function findOrderByReference($reference)
    {
        return $this->getRestClient()->getCommand('GetOrderByReference', array('reference' => $reference))->execute();
    }

    /**
     * @param int $id
     * @return \Ice\MercuryClientBundle\Entity\TransactionRequest
     */
    public function getTransactionRequestById($id)
    {
        return $this->getRestClient()->getCommand('GetTransactionRequest', array('id' => $id))->execute();
    }

    /**
     * @param int $reference
     * @return \Ice\MercuryClientBundle\Entity\TransactionRequest
     */
    public function getTransactionRequestByReference($reference)
    {
        return $this->getRestClient()->getCommand('GetTransactionRequestByReference', array('reference' => $reference))->execute();
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\Order[]|ArrayCollection
     */
    public function findAllOrders()
    {
        return $this->getRestClient()->getCommand('GetOrders')->execute();
    }

    /**
     * @return OrderBuilder
     */
    public function getNewOrderBuilder()
    {
        return new OrderBuilder();
    }

    /**
     * @return TransactionBuilder
     */
    public function getNewTransactionBuilder()
    {
        return new TransactionBuilder();
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
            $response = $e->getResponse()->__toString();
            //TODO: Translate into a usable error
            throw $e;
        }
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function createTransaction(Transaction $transaction)
    {
        try {
            /** @var $command OperationCommand */
            $command = $this->getRestClient()->getCommand('CreateTransaction', array('transaction' => $transaction));
            $command->prepare();
            $body = $command->getRequest()->__toString();
            return $command->execute();
        } catch (BadResponseException $e) {
            $response = $e->getResponse()->__toString();
            //TODO: Translate into a usable error
            throw $e;
        }
    }

    /**
     * @param Order $order
     * @return TransactionRequest
     * @throws \Exception|\Guzzle\Http\Exception\BadResponseException
     */
    public function requestOutstandingOnlineTransactionsByOrder(Order $order)
    {
        $request = new TransactionRequest();
        $components = array();
        foreach ($order->getSuborders() as $suborder) {
            foreach ($suborder->getPaymentGroup()->getReceivables() as $receivable) {
                if (
                    Receivable::METHOD_ONLINE === $receivable->getMethod() &&
                    $receivable->getDueDate() < new \DateTime()
                ) {
                    $component = new TransactionRequestComponent();
                    $component->setRequestAmount($receivable->getAmount());
                    $component->setPaymentGroup($suborder->getPaymentGroup());
                    $components[] = $component;
                }
            }
        }
        $request->setComponents($components);
        $request->setIceId($order->getIceId());

        if ($request->getTotalRequestAmount() === 0) {
            return $request;
        }

        try {
            /** @var $command OperationCommand */
            $command = $this->getRestClient()->getCommand('CreateTransactionRequest', array('request' => $request));
            return $command->execute();
        } catch (BadResponseException $e) {
            //TODO: Translate into a usable error
            throw $e;
        }
    }


    /**
     * @param int $id
     * @return \Ice\MercuryClientBundle\Entity\PaymentGroup
     */
    public function findSuborderGroupById($id)
    {
        return $this->getRestClient()->getCommand('GetSuborderGroup', array('id' => $id))->execute();
    }
}