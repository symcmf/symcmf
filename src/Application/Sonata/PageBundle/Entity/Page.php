<?php

namespace Application\Sonata\PageBundle\Entity;

use Sonata\PageBundle\Entity\BasePage as BasePage;

/**
 * Class Page
 * @package Application\Sonata\PageBundle\Entity
 */
class Page extends BasePage
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
