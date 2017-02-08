<?php

namespace MessageBundle\Entity;

use AppBundle\Entity\Traits\IdTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use MessageBundle\Model\MessageTemplateInterface;
use MessageBundle\Model\MessageUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="message_template")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageTemplate implements MessageTemplateInterface
{
    use IdTrait, TimestampableTrait;

    /**
     * @ORM\OneToMany(targetEntity="MessageUser", mappedBy="message", cascade={"remove"}, orphanRemoval=true)
     */
    private $messageUser;

    /**
     * @param MessageUserInterface $messageUser
     */
    public function addMessageUser(MessageUserInterface $messageUser)
    {
        $this->messageUser->add($messageUser);
    }

    /**
     * @param MessageUserInterface $messageUser
     */
    public function removeMessageUser(MessageUserInterface $messageUser)
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
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Subject must be at least {{ limit }} characters long",
     *      maxMessage = "Subject can't be longer than {{ limit }} characters"
     * )
     */
    private $subject;

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="text")
     */
    private $template;

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Template "' . $this->subject . '"';
    }
}
