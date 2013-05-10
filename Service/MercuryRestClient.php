<?php
namespace Ice\MercuryClientBundle\Service;

use Guzzle\Service\Client;

class MercuryRestClient extends Client
{

    /**
     * @param string $baseUrl
     * @param string $username
     * @param string $password
     * @param null   $config
     *
     * @internal param \Guzzle\Service\Client $guzzleClient
     */
    public function __construct($baseUrl = '', $username, $password, $config = null){
        parent::__construct($baseUrl, $config);
        $this->setConfig(array(
            'curl.options' => array(
                'CURLOPT_USERPWD' => sprintf("%s:%s", $username, $password),
            ),
        ));
        $this->setDefaultHeaders(array(
            'Accept' => 'application/json',
        ));
    }
}