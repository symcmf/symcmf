<?php

namespace Application\Sonata\MediaBundle\Document;

use Sonata\MediaBundle\Document\BaseMedia as BaseMedia;

/**
 * Class Media
 * @package Application\Sonata\MediaBundle\Document
 */
class Media extends BaseMedia
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
