<?php

namespace Application\Sonata\NewsBundle\Document;

use Sonata\NewsBundle\Document\BasePost as BasePost;

/**
 * Class Post
 * @package Application\Sonata\NewsBundle\Document
 */
class Post extends BasePost
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
