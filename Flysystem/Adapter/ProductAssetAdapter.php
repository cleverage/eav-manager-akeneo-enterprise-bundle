<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Flysystem\Adapter;

use Akeneo\Pim\ApiClient\Exception\ExceptionInterface;
use Akeneo\Pim\ApiClient\Exception\NotFoundHttpException;
use Akeneo\Pim\ApiClient\Exception\UnprocessableEntityHttpException;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use Akeneo\PimEnterprise\ApiClient\Exception\UploadAssetReferenceFileErrorException;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

/**
 * Class ProductAssetAdapter
 * @package CleverAge\EAVManager\AkeneoProductBundle\Flysystem
 */
class ProductAssetAdapter extends AbstractAdapter
{
    /** @var AkeneoPimEnterpriseClientInterface */
    protected $client;

    public function __construct(AkeneoPimEnterpriseClientInterface $client)
    {
        $this->client = $client;
    }

    public function write($assetCode, $contents, Config $config)
    {
        try {
            $test = $this->client->getAssetApi()->create($assetCode, [
            ]);
        } catch (UnprocessableEntityHttpException $e) {
            throw new UploadException($this->generateErrorMessages($e));
        }

        throw new \Exception(json_encode($test));
    }

    public function writeStream($assetCode, $resource, Config $config)
    {
        try {
            $this->client->getAssetApi()->create($assetCode);
            $test = $this->client->getAssetReferenceFileApi()->uploadForNotLocalizableAsset($resource, $assetCode);
        } catch (UnprocessableEntityHttpException $e) {
            throw new UploadException($this->generateErrorMessages($e, $e->getResponseErrors()));
        } catch (UploadAssetReferenceFileErrorException $e) {
            throw new UploadException($this->generateErrorMessages($e, $e->getErrors()));
        }

        return true;
    }

    /**
     * @TODO
     */
    public function update($assetCode, $contents, Config $config)
    {
    }

    public function updateStream($assetCode, $resource, Config $config)
    {
        try {
            $test = $this->client->getAssetReferenceFileApi()->uploadForNotLocalizableAsset($resource, $assetCode);
        } catch (UnprocessableEntityHttpException $e) {
            throw new UploadException($this->generateErrorMessages($e, $e->getResponseErrors()));
        } catch (UploadAssetReferenceFileErrorException $e) {
            throw new UploadException($this->generateErrorMessages($e, $e->getErrors()));
        }

        return true;
    }

    public function rename($path, $newpath)
    {
        // TODO: Implement rename() method.
    }

    public function copy($path, $newpath)
    {
        // TODO: Implement copy() method.
    }

    public function delete($path)
    {
        // TODO: Implement delete() method.
    }

    public function deleteDir($dirname)
    {
        // TODO: Implement deleteDir() method.
    }

    public function createDir($dirname, Config $config)
    {
        // TODO: Implement createDir() method.
    }

    public function setVisibility($path, $visibility)
    {
        // TODO: Implement setVisibility() method.
    }

    public function has($assetCode)
    {
        try {
            $this->client->getAssetApi()->get($assetCode);
        } catch (NotFoundHttpException $e) {
            return false;
        }

        return true;
    }

    public function read($path)
    {
        // TODO: Implement read() method.
    }

    public function readStream($path)
    {
        // TODO: Implement readStream() method.
    }

    public function listContents($directory = '', $recursive = false)
    {
        // TODO: Implement listContents() method.
    }

    public function getMetadata($assetCode)
    {
        if ($this->has($assetCode)) {
            return [
                'type' => 'file',
                'path' => $assetCode,
            ];
        }

        return false;
    }

    public function getSize($path)
    {
        // TODO: Implement getSize() method.
    }

    public function getMimetype($path)
    {
        // TODO: Implement getMimetype() method.
    }

    public function getTimestamp($path)
    {
        // TODO: Implement getTimestamp() method.
    }

    public function getVisibility($path)
    {
        // TODO: Implement getVisibility() method.
    }

    /**
     * @param UnprocessableEntityHttpException $e
     * @return string
     */
    private function generateErrorMessages(ExceptionInterface $e, array $errors = []): string
    {
        $message = $e->getMessage(). ' : ';
        foreach ($errors as $error) {
            $message .= $error['message'];
            $message .=' ';
        }

        return $message;
    }

}