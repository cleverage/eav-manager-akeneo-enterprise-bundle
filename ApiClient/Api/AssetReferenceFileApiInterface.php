<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient\Api;

interface AssetReferenceFileApiInterface
{
    public function downloadAsset(string $assetcode, string $locale = AssetReferenceFileApi::NOT_LOCALIZABLE_ASSET_LOCALE_CODE);
}