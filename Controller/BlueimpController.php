<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Controller;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\File\AssetFile;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\Response\AssetResponse;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\Request;

class BlueimpController extends \Sidus\FileUploadBundle\Controller\BlueimpController
{
    public function upload()
    {
        $request = $this->getRequest();

        $response = new AssetResponse();
        $files = $this->getFiles($request->files);
        $file = new AssetFile(
            reset($files),
            $this->createAssetCode($request)
        );

        try {
            $this->handleUpload($file, $response, $request);
        } catch (UploadException $e) {
            $this->errorHandler->addException($response, $e);
        }

        return $this->createSupportedJsonResponse($response->assemble());
    }

    protected function createAssetCode(Request $request)
    {
        return sprintf('%s_%s',  $request->query->get('prefix'), (new \DateTime())->format('Ymd'));
    }
}