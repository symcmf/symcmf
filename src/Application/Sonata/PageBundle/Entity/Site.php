<?php

namespace Application\Sonata\PageBundle\Entity;

use Sonata\PageBundle\Entity\BaseSite as BaseSite;

/**
 * Class Site
 * @package Application\Sonata\PageBundle\Entity
 */
class Site extends BaseSite
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
