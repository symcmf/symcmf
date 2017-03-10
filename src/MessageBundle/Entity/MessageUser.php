<?php

namespace MessageBundle\Entity;

use AppBundle\Entity\Traits\IdTrait;
use Application\Sonata\UserBundle\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;
use MessageBundle\Model\MessageTemplateInterface;
use MessageBundle\Model\MessageUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="message_user")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageUser implements MessageUserInterface
{
    use IdTrait;

    /**
     * @var MessageTemplateInterface
     *
     * @ORM\ManyToOne(targetEntity="MessageTemplate", inversedBy="messageUser")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id", nullable=false)
     * @Groups({"sonata_api_read", "sonata_api_write"})
     *
     * @Assert\NotNull()
     */
    protected $message;

    /**
     * @return MessageTemplateInterface,
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param MessageTemplateInterface|null $message
     * @return $this
     */
    public function setMessage(MessageTemplateInterface $message = null)
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
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="messageUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Groups({"sonata_api_read", "sonata_api_write"})
     */
    protected $user;

    /**
     * @Groups({"sonata_api_read", "sonata_api_write"})
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     * @return $this
     */
    public function setUser(UserInterface $user = null)
    {
        if ($this->user !== null) {
            $this->user->removeMessageUser($this);
        }
        if ($user !== null) {
            $user->addMessageUser($this);
        }
        $this->user = $user;
        return $this;
    }

    /**
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\ManyToOne(targetEntity="MessageUser")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * Get created
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
        $msg = $this->message ? $this->message->getSubject() : '<name>';
        return 'Message "' . $msg . '"';
    }
}
