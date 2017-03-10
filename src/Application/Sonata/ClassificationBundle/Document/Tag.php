<?php

namespace Application\Sonata\ClassificationBundle\Document;

use Sonata\ClassificationBundle\Document\BaseTag as BaseTag;

/**
 * Class Tag
 * @package Application\Sonata\ClassificationBundle\Document
 */
class Tag extends BaseTag
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
