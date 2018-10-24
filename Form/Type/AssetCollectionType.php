<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Form\Type;

use Sidus\EAVBootstrapBundle\Form\Type\BootstrapCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetCollectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(['filename_prefix']);
        $resolver->setDefault('allow_add', true);
        $resolver->setDefault('allow_delete', true);
        $resolver->setDefault('entry_type', AssetType::class);
        $resolver->setDefault('entry_options', function (Options $options) {
            return [
                'filename_prefix' => $options['filename_prefix'],
                'label' => false,
            ];
        });

    }

    public function getParent()
    {
        return BootstrapCollectionType::class;
    }
}