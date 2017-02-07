<?php

namespace Application\Sonata\ClassificationBundle\Document;

use Sonata\ClassificationBundle\Document\BaseCategory as BaseCategory;

/**
 * Class Category
 * @package Application\Sonata\ClassificationBundle\Document
 */
class Category extends BaseCategory
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
