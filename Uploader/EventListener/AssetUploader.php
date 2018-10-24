<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\EventListener;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\Model\Asset;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\Response\AssetResponse;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\Config\Definition\Exception\Exception;

class AssetUploader
{
    /**
     * @param PostPersistEvent $event
     *
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     *
     * @return AbstractResponse
     */
    public function onUpload(PostPersistEvent $event)
    {
        $file = $event->getFile();
        if (!$file instanceof Asset) {
            return;
        }

        /** @var AssetResponse $response */
        $response = $event->getResponse();
        $response[] = $file;

        return $response;
    }
}