<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\BaseContext as BaseContext;

/**
 * Class Context
 * @package Application\Sonata\ClassificationBundle\Entity
 */
class Context extends BaseContext
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
