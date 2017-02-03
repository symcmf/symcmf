<?php

namespace MessageBundle\Entity;

use AppBundle\Entity\Traits\IdTrait;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="message_user")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageUser
{
    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="MessageTemplate", inversedBy="messageUser")
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
    public function setMessage(MessageTemplate $message = null)
    {
        if ($this->message !== null) {
            $this->message->removeMessageUser($this);
        }
        if ($message !== null) {
            $message->addMessageUser($this);
        }
        $this->message = $message;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="messageUser")
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
     * @param array|User|null $user
     * @return $this
     */
    public function setUser($user = null)
    {
        if (!array($user)) {

            if ($this->user !== null) {
                $this->user->removeMessagesUser($this);
            }
            if ($user !== null) {
                $user->addMessagesUser($this);
            }
        }
        $this->user = $user;
        return $this;
    }

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\ManyToOne(targetEntity="MessageUser")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * Get created
     *
     * @return string
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

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Message "' . $this->message->getSubject(). '"';
    }
}
