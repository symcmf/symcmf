<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\BaseCollection as BaseCollection;

/**
 * Class Collection
 * @package Application\Sonata\ClassificationBundle\Entity
 */
class Collection extends BaseCollection
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}
