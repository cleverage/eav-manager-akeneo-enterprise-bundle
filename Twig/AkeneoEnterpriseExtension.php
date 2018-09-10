<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Twig;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\Workflow\Status;
use ReflectionClass;
use Twig\Extension\AbstractExtension;
use Twig_Extension_GlobalsInterface;

class AkeneoEnterpriseExtension extends AbstractExtension implements Twig_Extension_GlobalsInterface
{
    public function getGlobals()
    {
        $status = new ReflectionClass(Status::class);

        return [
            $status->getShortName() => $status->getConstants(),
        ];
    }

    public function getName()
    {
        return 'akeneo_entreprise_extension';
    }
}
