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
use Ice\MercuryClientBundle\Entity\TransactionReportLine;
use Ice\MercuryClientBundle\Entity\PaymentGroup;

class MercuryClient
{
    /**
     * @var MercuryRestClient
     */
    private $restClient;

    /**
     * @var PaymentPagesService
     */
    private $paymentPagesService;

    /**
     * @var string
     */
    private $gatewayMethod;

    /**
     * @param string $gatewayMethod
     * @return MercuryClient
     */
    public function setGatewayMethod($gatewayMethod)
    {
        $this->gatewayMethod = $gatewayMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getGatewayMethod()
    {
        return $this->gatewayMethod;
    }

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
     * @param string $iceId
     * @return \Ice\MercuryClientBundle\Entity\Order[]|ArrayCollection
     */
    public function findOrdersByCustomer($iceId)
    {
        return $this->getRestClient()->getCommand('GetOrders', array('customer'=>$iceId))->execute();
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
     * Build (but don't create) a TransactionRequest for anything outstanding on this order. Useful in isolation
     * to tell whether anything would be taken by requestOutstandingOnlineTransactionsByOrder without needing to
     * POST to Mercury
     *
     * @param Order $order
     * @return TransactionRequest
     */
    public function buildOutstandingOnlineFirstPaymentsRequestByOrder(Order $order)
    {
        $request = new TransactionRequest();
        $components = array();
        foreach ($order->getSuborders() as $suborder) {
            $component = new TransactionRequestComponent();
            $component->setRequestAmount($suborder->getPaymentGroup()->getOutstandingOnlineFirstPaymentAmount());
            $component->setPaymentGroup($suborder->getPaymentGroup());
            if ($component->getRequestAmount() > 0) {
                $components[] = $component;
            }
        }
        $request->setComponents($components);
        $request->setIceId($order->getIceId());
        $request->setRequestAccountTypeDescription($this->getGatewayMethod());
        return $request;
    }

    /**
     * @param Order $order
     * @deprecated Use requestOutstandingOnlineFirstPaymentsByOrder
     * @return TransactionRequest
     * @throws \Exception|\Guzzle\Http\Exception\BadResponseException
     */
    public function requestOutstandingOnlineTransactionsByOrder(Order $order)
    {
        return $this->requestOutstandingOnlineFirstPaymentsByOrder($order);
    }

    /**
     * @param Order $order
     * @return TransactionRequest
     * @throws \Exception|\Guzzle\Http\Exception\BadResponseException
     */
    public function requestOutstandingOnlineFirstPaymentsByOrder(Order $order)
    {
        $request = $this->buildOutstandingOnlineFirstPaymentsRequestByOrder($order);

        if ($request->getTotalRequestAmount() === 0) {
            return $request;
        }
        try {
            /** @var $command OperationCommand */
            $command = $this->getRestClient()->getCommand('CreateTransactionRequest', array(
                'request' => $request
            ));
            return $command->execute();
        } catch (BadResponseException $e) {
            //TODO: Translate into a usable error
            throw $e;
        }
    }

    /**
     * @param \Ice\MercuryClientBundle\Service\PaymentPagesService $paymentPagesService
     * @return MercuryClient
     */
    public function setPaymentPagesService($paymentPagesService)
    {
        $this->paymentPagesService = $paymentPagesService;
        return $this;
    }

    /**
     * @return \Ice\MercuryClientBundle\Service\PaymentPagesService
     */
    public function getPaymentPagesService()
    {
        return $this->paymentPagesService;
    }


    /**
     * @param \DateTime $day
     * @return ArrayCollection|TransactionReportLine[]
     */
    public function getTransactionReportByDay(\DateTime $day)
    {
        return $this->getRestClient()->getCommand('GetTransactionReportByDay', [
            'year' => $day->format('Y'),
            'month' => $day->format('m'),
            'day' => $day->format('d')
        ])->execute();
    }

    /**
     * Get a payment group by ID
     *
     * @param $id
     * @return PaymentGroup
     */
    public function getPaymentGroup($id)
    {
        return $this->getRestClient()->getCommand('getPaymentGroup', [
            'id' =>$id
        ])->execute();
    }

    /**
     * Get a payment group by ID
     *
     * @param $externalId
     * @return PaymentGroup
     */
    public function getPaymentGroupByExternalId($externalId)
    {
        return $this->getRestClient()->getCommand('getPaymentGroupByExternalId', [
            'externalId' =>$externalId
        ])->execute();
    }
}