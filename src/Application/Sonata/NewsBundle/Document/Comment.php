<?php

namespace Application\Sonata\NewsBundle\Document;

use Sonata\NewsBundle\Document\BaseComment as BaseComment;

/**
 * Class Comment
 * @package Application\Sonata\NewsBundle\Document
 */
class Comment extends BaseComment
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
