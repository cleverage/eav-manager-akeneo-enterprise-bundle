<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Controller;

use Akeneo\Pim\ApiClient\Exception\HttpException;
use Akeneo\Pim\ApiClient\Exception\NotFoundHttpException;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Security\Voter\ProductVoter;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class ProductController extends \CleverAge\EAVManager\AkeneoProductBundle\Controller\ProductController
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function handleForm(Request $request, Form $form)
    {
        if (!$form->has('proposal') || !$form->get('proposal')->isClicked()) {
            return parent::handleForm($request, $form);
        }

        $identifier = $request->get('identifier');

        try {
            $this->get(AkeneoPimClientInterface::class)->getProductDraftApi()->submitForApproval($identifier);
            $this->addFlash('success', $this->translate('admin.flash.proposal.success'));
        } catch (HttpException $e) {
            $this->get('logger')->error($e->getMessage());
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToAction('edit', compact('identifier'));
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \Akeneo\Pim\ApiClient\Exception\HttpException
     */
    protected function getProduct($id): array
    {
        if ($this->isGranted(ProductVoter::NOT_OWNER)) {
            try {
                return $this->get(AkeneoPimClientInterface::class)->getProductDraftApi()->get($id);
            } catch (NotFoundHttpException $e) {}
        }

        return $this->get(AkeneoPimClientInterface::class)->getProductApi()->get($id);
    }
}
