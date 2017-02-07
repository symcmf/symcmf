<?php

namespace Application\Sonata\MediaBundle\PHPCR;

use Sonata\MediaBundle\PHPCR\BaseGallery as BaseGallery;

/**
 * Class Gallery
 * @package Application\Sonata\MediaBundle\PHPCR
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
