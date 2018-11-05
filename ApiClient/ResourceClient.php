<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient;


class ResourceClient extends \Akeneo\Pim\ApiClient\Client\ResourceClient
{
    public function getStreamedResponse($uri, array $uriParameters = [])
    {
        $uri = $this->uriGenerator->generate($uri, $uriParameters);

        return $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);
    }
}