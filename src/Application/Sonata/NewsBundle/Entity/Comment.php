<?php

namespace Application\Sonata\NewsBundle\Entity;

use Sonata\NewsBundle\Entity\BaseComment as BaseComment;

/**
 * Class Comment
 * @package Application\Sonata\NewsBundle\Entity
 */
class Comment extends BaseComment
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
