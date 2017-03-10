<?php

namespace Application\Sonata\NotificationBundle\Entity;

use Sonata\NotificationBundle\Entity\BaseMessage as BaseMessage;

/**
 * Class Message
 * @package Application\Sonata\NotificationBundle\Entity
 */
class Message extends BaseMessage
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
