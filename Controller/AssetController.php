<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Controller;

use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AssetController extends Controller
{
    public function viewReferenceFileAction(string $assetCode)
    {
        /** @var ResponseInterface $assetReponse */
        $assetReponse = $this->get(AkeneoPimEnterpriseClientInterface::class)->getAssetReferenceFileApi()->downloadAsset($assetCode);
        $content = $assetReponse->getBody()->getContents();
        $inlineDisposition = str_replace('attachment', 'inline', $assetReponse->getHeaderLine('Content-Disposition'));

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $assetReponse->getHeaderLine('Content-type') );
        $response->headers->set('Content-Disposition', $inlineDisposition);
        $response->headers->set('Content-length',  strlen($content));
        $response->sendHeaders();
        $response->setContent($content);

        return $response;
    }
}