<?php
namespace Ice\MercuryClientBundle\Builder;

use Ice\MercuryClientBundle\Entity\Order;
use Ice\MercuryClientBundle\Entity\Transaction;
use Ice\MercuryClientBundle\Entity\TransactionRequest;

class TransactionBuilder
{
    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * Pass in an existing transaction entity, if appropriate, otherwise a new one will be created
     *
     * @param Transaction|null $transaction
     */
    public function __construct($transaction = null)
    {
        if (null === $transaction) {
            $transaction = new Transaction();
        }
        $this->transaction = $transaction;
    }

    /**
     * @param TransactionRequest $transactionRequest
     * @return TransactionBuilder
     */
    public function setTransactionRequest(TransactionRequest $transactionRequest)
    {
        $this->transaction->setTransactionRequest($transactionRequest);
        $this->transaction->setAmountReceived($transactionRequest->getTotalRequestAmount());
        $this->transaction->setCurrency($transactionRequest->getRequestCurrency());
        $this->transaction->setMethod('CHEQUE');
        return $this;
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }
}
