<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Form\Type;

use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use Assetic\Factory\Resource\ResourceInterface;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Model\Asset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetType extends AbstractType
{
    /** @var AkeneoPimEnterpriseClientInterface */
    protected $client;

    public function __construct(AkeneoPimEnterpriseClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var ResourceTypeConfiguration $resourceType */
        $view->vars['endpoint'] = 'product_asset';
        $view->vars['data'] = $form->getData()
            ? Asset::fromApi($this->client->getAssetApi()->get($form->getData())) : null;
        $view->vars['prefix'] = $options['filename_prefix'];
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['filename_prefix']);
        $resolver->setAllowedTypes('filename_prefix', ['string']);
        $resolver->setDefault('compound', false);
    }
}