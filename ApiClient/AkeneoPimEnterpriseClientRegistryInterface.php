<?php


namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient;

use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use CleverAge\EAVManager\AkeneoProductBundle\ApiClient\AkeneoPimClientCommonRegistryInterface;

interface AkeneoPimEnterpriseClientRegistryInterface extends AkeneoPimClientCommonRegistryInterface
{
    public function getClient(): AkeneoPimEnterpriseClientInterface;
}
