<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient;

use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClient;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Api\CategoryApi;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApi;
use Akeneo\Pim\ApiClient\Api\ProductApi;
use Akeneo\Pim\ApiClient\Api\ProductMediaFileApi;
use Akeneo\Pim\ApiClient\Api\ProductModelApi;
use Akeneo\Pim\ApiClient\Security\Authentication;
use Akeneo\PimEnterprise\ApiClient\Api\ProductDraftApi;
use Akeneo\PimEnterprise\ApiClient\Api\PublishedProductApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\AkeneoPimClientBuilder;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\AssociationTypeApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\AttributeApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\AttributeGroupApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\AttributeOptionApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\ChannelApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\CurrencyApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\FamilyApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\LocaleApi;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\Api\MeasureFamilyApi;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class AkeneoPimEnterpriseClientBuilder extends AkeneoPimClientBuilder
{
    /**
     * @param Authentication $authentication
     *
     * @return AkeneoPimClientInterface
     */
    protected function buildAuthenticatedClient(Authentication $authentication)
    {
        list($resourceClient, $pageFactory, $cursorFactory) = $this->setUp($authentication);

        $client = new AkeneoPimEnterpriseClient(
            $authentication,
            new ProductApi($resourceClient, $pageFactory, $cursorFactory),
            new CategoryApi($resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AttributeApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AttributeOptionApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AttributeGroupApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(FamilyApi::class, $resourceClient, $pageFactory, $cursorFactory),
            new ProductMediaFileApi($resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(LocaleApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(ChannelApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(CurrencyApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(MeasureFamilyApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AssociationTypeApi::class, $resourceClient, $pageFactory, $cursorFactory),
            new FamilyVariantApi($resourceClient, $pageFactory, $cursorFactory),
            new ProductModelApi($resourceClient, $pageFactory, $cursorFactory),
            new PublishedProductApi($resourceClient, $pageFactory, $cursorFactory),
            new ProductDraftApi($resourceClient, $pageFactory, $cursorFactory)
        );

        return $client;
    }
}
