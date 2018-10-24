<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\File;

use Oneup\UploaderBundle\Uploader\File\FilesystemFile;
use Symfony\Component\HttpFoundation\File\File;

class AssetFile extends FilesystemFile
{
    /** @var string  */
    protected $code;

    public function __construct(File $file, string $code)
    {
        parent::__construct($file);
        $this->code = $code;
    }

    public function getAssetCode(): string
    {
        return $this->code;
    }
}