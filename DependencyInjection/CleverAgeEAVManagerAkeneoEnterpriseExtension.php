<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\DependencyInjection;

use Sidus\BaseBundle\DependencyInjection\Loader\ServiceLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class CleverAgeEAVManagerAkeneoEnterpriseExtension extends ConfigurableExtension
{
    public function loadInternal(array $config, ContainerBuilder $container)
    {
        $loader = new ServiceLoader($container);
        $loader->loadFiles(__DIR__.'/../Resources/config/services');

        $container->setParameter('eav_manager_akeneo_product_owners', $config['product_owners']);
        $container->setParameter('eav_manager_akeneo_public_uri', $config['public_uri']);

    }
}
