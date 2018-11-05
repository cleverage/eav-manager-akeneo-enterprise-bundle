<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient\Api;

use Akeneo\Pim\ApiClient\Client\ResourceClientInterface;
use Akeneo\Pim\ApiClient\FileSystem\FileSystemInterface;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient\ResourceClient;

class AssetReferenceFileApi extends \Akeneo\PimEnterprise\ApiClient\Api\AssetReferenceFileApi implements AssetReferenceFileApiInterface
{
    /** @var ResourceClientInterface */
    private $resourceClient;

    /** @var FileSystemInterface */
    private $fileSystem;

    /**
     * @param ResourceClientInterface $resourceClient
     * @param FileSystemInterface     $fileSystem
     */
    public function __construct(ResourceClientInterface $resourceClient, FileSystemInterface $fileSystem)
    {
        parent::__construct($resourceClient, $fileSystem);

        $this->resourceClient = $resourceClient;
        $this->fileSystem = $fileSystem;
    }


    public function downloadAsset(string $assetCode, string $locale = self::NOT_LOCALIZABLE_ASSET_LOCALE_CODE)
    {
        return $this->resourceClient->getStreamedResponse(static::ASSET_REFERENCE_FILE_DOWNLOAD_URI, [$assetCode, $locale]);
    }
}