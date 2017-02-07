<?php

namespace Application\Sonata\PageBundle\Entity;

use Sonata\PageBundle\Entity\BaseBlock as BaseBlock;

/**
 * Class Block
 * @package Application\Sonata\PageBundle\Entity
 */
class Block extends BaseBlock
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
