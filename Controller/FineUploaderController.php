<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Controller;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\File\AssetFile;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\Response\AssetResponse;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\Request;

class FineUploaderController extends \Oneup\UploaderBundle\Controller\FineUploaderController
{
    public function upload()
    {
        $request = $this->getRequest();
        $translator = $this->container->get('translator');

        $response = new AssetResponse();
        $files = $this->getFiles($request->files);
        $file = new AssetFile(
            reset($files),
            $this->createAssetCode($request)
        );

        try {
            $this->handleUpload($file, $response, $request);
        } catch (UploadException $e) {
            $response->setSuccess(false);
            $response->setError($translator->trans($e->getMessage(), array(), 'OneupUploaderBundle'));

            $this->errorHandler->addException($response, $e);

            // an error happended, return this error message.
            return $this->createSupportedJsonResponse($response->assemble());
        }

        return $this->createSupportedJsonResponse($response->assemble());
    }

    protected function createAssetCode(Request $request)
    {
        return sprintf('%s_%s',  $request->query->get('prefix'), (new \DateTime())->getTimestamp());
    }
}