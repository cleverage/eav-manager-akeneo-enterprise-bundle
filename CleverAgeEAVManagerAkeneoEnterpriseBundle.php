<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\DependencyInjection\Compiler\FormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class CleverAgeEAVManagerAkeneoEnterpriseBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormPass());
    }
}
