<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Form\Type;

use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Security\Voter\ProductVoter;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormRegistryInterface;
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
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        parent::__construct($client, $transformer, $formRegistry);

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
}
