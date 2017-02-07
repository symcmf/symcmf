<?php

namespace Application\Sonata\MediaBundle\PHPCR;

use Sonata\MediaBundle\PHPCR\BaseGalleryHasMedia as BaseGalleryHasMedia;

/**
 * Class GalleryHasMedia
 * @package Application\Sonata\MediaBundle\PHPCR
 */
class GalleryHasMedia extends BaseGalleryHasMedia
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
