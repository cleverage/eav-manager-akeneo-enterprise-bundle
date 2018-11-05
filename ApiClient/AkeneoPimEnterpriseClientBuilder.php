<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient;

use Akeneo\Pim\ApiClient\Api\AuthenticationApi;
use Akeneo\Pim\ApiClient\Client\AuthenticatedHttpClient;
use Akeneo\Pim\ApiClient\Client\HttpClient;
use Akeneo\Pim\ApiClient\FileSystem\LocalFileSystem;
use Akeneo\Pim\ApiClient\Pagination\PageFactory;
use Akeneo\Pim\ApiClient\Pagination\ResourceCursorFactory;
use Akeneo\Pim\ApiClient\Routing\UriGenerator;
use Akeneo\Pim\ApiClient\Stream\MultipartStreamBuilderFactory;
use Akeneo\Pim\ApiClient\Stream\UpsertResourceListResponseFactory;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClient;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Api\CategoryApi;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApi;
use Akeneo\Pim\ApiClient\Api\ProductApi;
use Akeneo\Pim\ApiClient\Api\ProductMediaFileApi;
use Akeneo\Pim\ApiClient\Api\ProductModelApi;
use Akeneo\Pim\ApiClient\Security\Authentication;
use Akeneo\PimEnterprise\ApiClient\Api\AssetApi;
use Akeneo\PimEnterprise\ApiClient\Api\AssetCategoryApi;
use Akeneo\PimEnterprise\ApiClient\Api\AssetTagApi;
use Akeneo\PimEnterprise\ApiClient\Api\AssetVariationFileApi;
use Akeneo\PimEnterprise\ApiClient\Api\ProductDraftApi;
use Akeneo\PimEnterprise\ApiClient\Api\ProductModelDraftApi;
use Akeneo\PimEnterprise\ApiClient\Api\PublishedProductApi;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient\Api\AssetReferenceFileApi;
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
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;

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
        list($resourceClient, $pageFactory, $cursorFactory, $fileSystem) = $this->setUp($authentication);

        $client = new AkeneoPimEnterpriseClient(
            $authentication,
            new ProductApi($resourceClient, $pageFactory, $cursorFactory),
            new CategoryApi($resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AttributeApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AttributeOptionApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AttributeGroupApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(FamilyApi::class, $resourceClient, $pageFactory, $cursorFactory),
            new ProductMediaFileApi($resourceClient, $pageFactory, $cursorFactory, $fileSystem),
            $this->createApiWithCache(LocaleApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(ChannelApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(CurrencyApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(MeasureFamilyApi::class, $resourceClient, $pageFactory, $cursorFactory),
            $this->createApiWithCache(AssociationTypeApi::class, $resourceClient, $pageFactory, $cursorFactory),
            new FamilyVariantApi($resourceClient, $pageFactory, $cursorFactory),
            new ProductModelApi($resourceClient, $pageFactory, $cursorFactory),
            new ProductModelDraftApi($resourceClient, $pageFactory, $cursorFactory),
            new PublishedProductApi($resourceClient, $pageFactory, $cursorFactory),
            new ProductDraftApi($resourceClient, $pageFactory, $cursorFactory),
            new AssetApi($resourceClient, $pageFactory, $cursorFactory),
            new AssetCategoryApi($resourceClient, $pageFactory, $cursorFactory),
            new AssetTagApi($resourceClient, $pageFactory, $cursorFactory),
            new AssetReferenceFileApi($resourceClient, $fileSystem),
            new AssetVariationFileApi($resourceClient, $fileSystem)
        );

        return $client;
    }

    /**
     * Forced to redefine this function in order to use the custom ResourceClient to download correctly asset
     */
    protected function setUp(Authentication $authentication)
    {
        $uriGenerator = new UriGenerator($this->baseUri);

        $httpClient = new HttpClient($this->getHttpClient(), $this->getRequestFactory());
        $authenticationApi = new AuthenticationApi($httpClient, $uriGenerator);
        $authenticatedHttpClient = new AuthenticatedHttpClient($httpClient, $authenticationApi, $authentication);

        $multipartStreamBuilderFactory = new MultipartStreamBuilderFactory($this->getStreamFactory());
        $upsertListResponseFactory = new UpsertResourceListResponseFactory();
        $resourceClient = new ResourceClient(
            $authenticatedHttpClient,
            $uriGenerator,
            $multipartStreamBuilderFactory,
            $upsertListResponseFactory
        );

        $pageFactory = new PageFactory($authenticatedHttpClient);
        $cursorFactory = new ResourceCursorFactory();
        $fileSystem = null !== $this->fileSystem ? $this->fileSystem : new LocalFileSystem();

        if ($this->stopwatch) {
            $resourceClient = new ResourceClientWrapper($resourceClient);
            $resourceClient->setStopwatch($this->stopwatch);
        }

        return [$resourceClient, $pageFactory, $cursorFactory, $fileSystem];
    }

    /**
    * @return Client
    */
    private function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = HttpClientDiscovery::find();
        }

        return $this->httpClient;
    }

    /**
     * @return RequestFactory
     */
    private function getRequestFactory()
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = MessageFactoryDiscovery::find();
        }

        return $this->requestFactory;
    }

    /**
     * @return StreamFactory
     */
    private function getStreamFactory()
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = StreamFactoryDiscovery::find();
        }

        return $this->streamFactory;
    }
}
