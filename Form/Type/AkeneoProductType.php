<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Form\Type;

use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Security\Voter\ProductVoter;
use CleverAge\EAVManager\AkeneoProductBundle\Attribute\Type\AkeneoAttributeTypes;
use CleverAge\EAVManager\AkeneoProductBundle\Form\EventListener\AkeneoListenerFactoryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class AkeneoProductType extends \CleverAge\EAVManager\AkeneoProductBundle\Form\Type\AkeneoProductType
{
    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /**
     * @param AkeneoPimClientInterface      $client
     * @param DataTransformerInterface      $transformer
     * @param FormRegistryInterface         $formRegistry
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        AkeneoPimClientInterface $client,
        DataTransformerInterface $transformer,
        FormRegistryInterface $formRegistry,
        AkeneoListenerFactoryInterface $akeneoListenerFactory,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        parent::__construct($client, $transformer, $formRegistry, $akeneoListenerFactory);

        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if ($this->authorizationChecker->isGranted(ProductVoter::NOT_OWNER)) {
            $builder->add('proposal', SubmitType::class);
        }
    }

    /**
     * @param array $attribute
     *
     * @return string
     */
    protected function getFormType(array $attribute): string
    {
        if (AkeneoAttributeTypes::ASSETS_COLLECTION === $attribute['type']) {
            return AssetCollectionType::class;
        }

        return parent::getFormType($attribute);
    }

    /**
     * @param string $formType
     * @param array $attribute
     * @param array $family
     * @param array $options
     * @return array
     */
    protected function getFormOptions(string $formType, array $attribute, array $family, array $options): array
    {
        $formOptions = parent::getFormOptions($formType, $attribute, $family, $options);

        if (AkeneoAttributeTypes::ASSETS_COLLECTION === $attribute['type']) {
            $formOptions['filename_prefix'] = $options['upload_filename_prefix'];
        }

        return $formOptions;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(
            array_merge(
                $resolver->getRequiredOptions(),
                [
                'upload_filename_prefix'
                ]
            )
        );

        $resolver->setAllowedTypes('upload_filename_prefix', ['string']);
    }
}
