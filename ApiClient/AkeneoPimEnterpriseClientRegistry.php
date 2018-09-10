<?php


namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\ApiClient;

use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class AkeneoPimEnterpriseClientRegistry implements AkeneoPimEnterpriseClientRegistryInterface
{
    /** @var AkeneoPimEnterpriseClientInterface */
    protected $client;

    public function __construct(AkeneoPimEnterpriseClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return AkeneoPimEnterpriseClientInterface
     */
    public function getClient(): AkeneoPimEnterpriseClientInterface
    {
        return $this->client;
    }
}
