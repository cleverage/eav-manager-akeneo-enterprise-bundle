<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\EventListener;

use CleverAge\EAVManager\AkeneoEnterpriseBundle\Model\Asset;
use CleverAge\EAVManager\AkeneoEnterpriseBundle\Uploader\Response\AssetResponse;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Sidus\AdminBundle\Routing\AdminRouter;
use Symfony\Component\Config\Definition\Exception\Exception;

class AssetUploader
{
    /** @var CacheManager */
    private $cacheManager;

    /** @var AdminRouter */
    protected $adminRouter;

    /**
     * Constructor.
     *
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager, AdminRouter $adminRouter)
    {
        $this->cacheManager = $cacheManager;
        $this->adminRouter = $adminRouter;
    }

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
        $response->setLink($this->adminRouter->generateAdminPath(
            'assets',
            'viewReferenceFile',
            [
                'assetCode' => $file->getIdentifier()
            ]
        ));
        $response->setThumbnailPath($this->cacheManager->getBrowserPath($file->getIdentifier(), 'asset_thumbnail'));

        return $response;
    }
}