<?php

namespace Ice\MercuryClientBundle\Service;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Service\Client;
use Guzzle\Service\Command\DefaultRequestSerializer;
use Guzzle\Service\Command\OperationCommand;
use Ice\MercuryClientBundle\Entity\CustomerInterface;
use Ice\MercuryClientBundle\Entity\TransactionRequest;
use Ice\MercuryClientBundle\Util\Country;

class PaymentPagesService
{
    /**
     * @var string
     */
    private $gatewaySecret;

    /**
     * @var string
     */
    private $iframeRootUrl;

    /**
     * @var string
     *
     * Default to test account, but this should be overwritten by the service container.
     */
    private $siteReference = 'test_uniofcam45561';

    /**
     * @param string $iframeRootUrl
     * @return PaymentPagesService
     */
    public function setIframeRootUrl($iframeRootUrl)
    {
        $this->iframeRootUrl = $iframeRootUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getIframeRootUrl()
    {
        return $this->iframeRootUrl;
    }

    /**
     * @param string $gatewaySecret
     * @return PaymentPagesService
     */
    public function setGatewaySecret($gatewaySecret)
    {
        $this->gatewaySecret = $gatewaySecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getGatewaySecret()
    {
        return $this->gatewaySecret;
    }

    /**
     * @param string $siteReference
     * @return PaymentPagesService
     */
    public function setSiteReference($siteReference)
    {
        $this->siteReference = $siteReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiteReference()
    {
        return $this->siteReference;
    }

    /**
     * Gets the absolute URL of the iframe to display in order to take payment for the given transaction request
     *
     * @param TransactionRequest $transactionRequest
     * @param \Ice\MercuryClientBundle\Entity\CustomerInterface $customer
     * @param bool $suspended
     * @return string
     */
    public function getIframeUrl(TransactionRequest $transactionRequest, $customer = null, $suspended = false)
    {
        if ($customer instanceof CustomerInterface) {
            $extraParams = [
                    'billingprefixname'=>$customer->getTitle(),
                    'billingfirstname'=>$customer->getFirstNames(),
                    'billinglastname'=>$customer->getLastNames(),
                    'billingpremise'=>$customer->getAddress1(),
                    'billingstreet'=>implode(', ', array_filter(
                        [$customer->getAddress2(), $customer->getAddress3(), $customer->getAddress4()]
                    )),
                    'billingtown'=>$customer->getTown(),
                    'billingpostcode'=>$customer->getPostcode(),
                    'billingcounty'=>$customer->getCounty(),
                    'billingcountryiso2a'=>Country::alpha3ToAlpha2($customer->getCountry()),
                    'billingemail'=>$customer->getEmail(),
                    'billingtelephone'=>$customer->getTelephone(),
                    'billingtelephonetype'=>'H'
                ];
        } else {
            $extraParams = [];
        }

        $params = array(
            'childcss'=>'stpp-public',
            'childjs'=>'stpp-resize',
            'sitereference'=>$this->getSiteReference(),
            'mainamount'=>$transactionRequest->getTotalRequestAmount() / 100,
            'currencyiso3a'=>'GBP',
            'version'=>1,
            'accounttypedescription'=>$transactionRequest->getRequestAccountTypeDescription(),
            'orderreference'=>$transactionRequest->getReference()
        );

        if ($suspended) {
            $params['settlestatus'] = 2;
            $params['mainamount'] = 1;
        }

        $hashData = $params['accounttypedescription'].
            $params['currencyiso3a'].
            $params['mainamount'].
            $params['sitereference'].
            (isset($params['settlestatus'])?$params['settlestatus']:'').
            (isset($params['settleduedate'])?$params['settleduedate']:'').
            $this->getGatewaySecret()
        ;

        $params['sitesecurity'] = 'g'.hash('sha256', $hashData);

        $queryString = http_build_query(array_merge($extraParams, $params));
        return $this->getIframeRootUrl().'?'.$queryString;
    }
}
