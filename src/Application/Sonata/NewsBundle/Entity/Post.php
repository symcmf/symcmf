<?php

namespace Application\Sonata\NewsBundle\Entity;

use Sonata\NewsBundle\Entity\BasePost as BasePost;

/**
 * Class Post
 * @package Application\Sonata\NewsBundle\Entity
 */
class Post extends BasePost
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
