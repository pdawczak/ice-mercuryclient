<?php
namespace Ice\MercuryClientBundle\Service;

use Guzzle\Service\Client;

class MercuryRestClient extends Client
{

    /**
     * @param \Guzzle\Service\Client $guzzleClient
     */
    public function __construct($baseUrl = '', $config = null){
        parent::__construct($baseUrl, $config);
        $this->setDefaultHeaders(array(
            'Accept'=> 'application/json'
        ));
    }
}