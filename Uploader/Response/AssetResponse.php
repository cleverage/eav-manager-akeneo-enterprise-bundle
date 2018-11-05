<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\Response;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\Model\Asset;
use Oneup\UploaderBundle\Uploader\Response\FineUploaderResponse;

class AssetResponse extends FineUploaderResponse
{
    protected $link;
    protected $thumbnailPath;

    public function assemble()
    {
        $data = parent::assemble();

        if ($this->link) {
            $data['link'] = $this->link;
        }

        if ($this->thumbnailPath) {
            $data['thumbnailPath'] = $this->thumbnailPath;
        }

        return $data;
    }

    public function setLink(string $link)
    {
        $this->link = $link;
    }

    public function setThumbnailPath(string $thumbnailPath)
    {
        $this->thumbnailPath = $thumbnailPath;
    }
}