<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Flysystem\Storage;

use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Model\Asset;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\File\AssetFile;
use League\Flysystem\Filesystem;
use Oneup\UploaderBundle\Uploader\File\FileInterface;;
use Oneup\UploaderBundle\Uploader\Storage\StorageInterface;
use Symfony\Component\Filesystem\Filesystem as LocalFilesystem;

class ProductAssetStorage implements StorageInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /** @var AkeneoPimEnterpriseClientInterface */
    protected $client;

    public function __construct(Filesystem $filesystem, AkeneoPimEnterpriseClientInterface $client)
    {
        $this->filesystem = $filesystem;
        $this->client = $client;
    }

    /**
     * @param AssetFile|FileInterface $file
     * @param string $name
     * @param null $path
     * @return FlysystemFile
     */
    public function upload(FileInterface $file, $name, $path = null)
    {
        $updatedFile = new AssetFile($file->move($file->getPath(), $name), $file->getAssetCode());

        $stream = fopen($updatedFile->getPathname(), 'r+b');
        $this->filesystem->putStream($updatedFile->getAssetCode(), $stream, array(
            'mimetype' => $updatedFile->getMimeType(),
        ));

        if (is_resource($stream)) {
            fclose($stream);
        }

        $filesystem = new LocalFileSystem();
        $filesystem->remove($updatedFile->getPathname());

        return Asset::fromApi($this->client->getAssetApi()->get($file->getAssetCode()));
    }
}