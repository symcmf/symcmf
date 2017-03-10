<?php

namespace Application\Sonata\PageBundle\Entity;

use Sonata\PageBundle\Entity\BaseSnapshot as BaseSnapshot;

/**
 * Class Snapshot
 * @package Application\Sonata\PageBundle\Entity
 */
class Snapshot extends BaseSnapshot
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
