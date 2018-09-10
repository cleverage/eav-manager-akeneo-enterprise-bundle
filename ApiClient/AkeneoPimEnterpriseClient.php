<?php


namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient;

use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\AkeneoPimClient;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class AkeneoPimEnterpriseClient extends AkeneoPimClient implements AkeneoPimEnterpriseClientInterface
{
    /** @var AkeneoPimEnterpriseClientRegistryInterface */
    protected $clientRegistry;

    public function getPublishedProductApi()
    {
        return $this->clientRegistry->getClient()->getPublishedProductApi();
    }

    public function getProductDraftApi()
    {
        return $this->clientRegistry->getClient()->getProductDraftApi();
    }
}
