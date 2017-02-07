<?php

namespace Application\Sonata\MediaBundle\Document;

use Sonata\MediaBundle\Document\BaseGallery as BaseGallery;

/**
 * Class Gallery
 * @package Application\Sonata\MediaBundle\Document
 */
class Gallery extends BaseGallery
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
}
