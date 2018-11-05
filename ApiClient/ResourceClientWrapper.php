<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient;

class ResourceClientWrapper extends \CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Client\ResourceClientWrapper
{
    public function getStreamedResponse($uri, array $uriParameters = [])
    {
        return $this->resourceClient->getStreamedResponse($uri, $uriParameters);
    }
}