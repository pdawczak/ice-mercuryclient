<?php
namespace Ice\MercuryClientBundle\Service;

use Guzzle\Service\Client;

class MercuryRestClient extends Client
{
    /** @var \Guzzle\Service\Client */
    private $guzzleClient;

    /**
     * @param \Guzzle\Service\Client $guzzleClient
     */
    public function setGuzzleClient(Client $guzzleClient){
        $this->guzzleClient = $guzzleClient;
        $this->guzzleClient->setDefaultHeaders(array(
            'Accepts' => 'application/json',
        ));
    }

    /**
     * @return \Guzzle\Service\Client
     */
    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }
}