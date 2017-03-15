<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use MessageBundle\Entity\MessageUser;
use Application\Sonata\UserBundle\Entity\ApplicationBaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Application\Sonata\UserBundle\Entity
 */
class User extends BaseUser
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->messageUser = new ArrayCollection();
    }

    /**
     * @var integer $id
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

    /**
     * @var array
     */
    protected $messageUser;

    /**
     * @param MessageUser $messageUser
     */
    public function addMessageUser(MessageUser $messageUser)
    {
        $this->messageUser->add($messageUser);
    }

    /**
     * @param MessageUser $messageUser
     */
    public function removeMessageUser(MessageUser $messageUser)
    {
        $this->messageUser->removeElement($messageUser);
    }

    /**
     * @return array
     */
    public function getMessageUser()
    {
        return $this->messageUser->toArray();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->email;
    }
}
