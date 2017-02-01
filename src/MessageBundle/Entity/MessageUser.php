<?php

namespace MessageBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="message_user")
 */
class MessageUser
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="MessageTemplate", inversedBy="EmailUser")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id", nullable=false)
     */
    protected $message;

    /**
     * @return MessageTemplate,
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param MessageTemplate|null $message
     *
     * @return $this
     */
    public function addMessage(MessageTemplate $message = null)
    {
        if ($this->message !== null) {
            $this->message->removeUser($this);
        }
        if ($message !== null) {
            $message->addUser($this);
        }
        $this->message = $message;
        return $this;
    }

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="EmailUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $id
     */
    public function setUser($id)
    {
        $this->user = $id;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function addUser(User $user = null)
    {
        if ($this->user !== null) {
            $this->user->remove($this);
        }
        if ($user !== null) {
            $user->addProjectUser($this);
        }
        $this->user = $user;
        return $this;
    }

    /**
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }
}
