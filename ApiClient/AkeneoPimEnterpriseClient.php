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

    /**
     * {@inheritdoc}
     */
    public function getProductModelDraftApi()
    {
        return $this->clientRegistry->getClient()->getProductModelDraftApi();
    }

    /**
     * {@inheritdoc}
     */
    public function getProductDraftApi()
    {
        return $this->clientRegistry->getClient()->getProductDraftApi();
    }

    /**
     * @return AssetApiInterface
     */
    public function getAssetApi()
    {
        return $this->clientRegistry->getClient()->getAssetApi();
    }

    /**
     * {@inheritdoc}
     */
    public function getAssetCategoryApi()
    {
        return $this->clientRegistry->getClient()->getAssetCategoryApi();
    }

    /**
     * {@inheritdoc}
     */
    public function getAssetTagApi()
    {
        return $this->clientRegistry->getClient()->getAssetTagApi();
    }

    /**
     * {@inheritdoc}
     */
    public function getAssetReferenceFileApi()
    {
        return $this->clientRegistry->getClient()->getAssetReferenceFileApi();
    }

    /**
     * {@inheritdoc}
     */
    public function getAssetVariationFileApi()
    {
        return $this->clientRegistry->getClient()->getAssetVariationFileApi();
    }
}
