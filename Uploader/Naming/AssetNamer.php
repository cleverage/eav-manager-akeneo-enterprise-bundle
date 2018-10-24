<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\Naming;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\File\AssetFile;
use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;

class AssetNamer implements NamerInterface
{
    /**
     * @param AssetFile|FileInterface $file
     * @return string|void
     */
    public function name(FileInterface $file)
    {
        return sprintf('%s.%s', $file->getAssetCode(), $file->getExtension());
    }
}