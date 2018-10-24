<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Model;

use Sidus\FileUploadBundle\Model\ResourceInterface;

class Asset implements ResourceInterface, \JsonSerializable
{
    private $code;

    private $originalFileName;

    private $url;

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->code = $data['code'];
        $this->originalFileName = basename($data['reference_files'][0]['code']);
        $this->url = $data['reference_files'][0]['_link']['download']['href'];
    }

    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }

    public function setOriginalFileName($originalFileName)
    {
        $this->originalFileName = $originalFileName;
    }

    public function getPath()
    {
        return $this->url;
    }

    public function setPath($url)
    {
       $this->url = $url;
    }

    public function getHash()
    {
        // TODO: Implement getHash() method.
    }

    public function setHash($hash)
    {
        // TODO: Implement setHash() method.
    }

    public static function getType()
    {
        // TODO: Implement getType() method.
    }

    public function getIdentifier()
    {
        return $this->code;
    }

    public static function fromApi(array $data): self
    {
        return new self($data);

    }


    /**
     * Serialize automatically the entity when passed to json_encode
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'identifier' => $this->getIdentifier(),
            'path' => $this->getPath(),
            'originalFileName' => $this->getOriginalFileName(),
        ];
    }
}

