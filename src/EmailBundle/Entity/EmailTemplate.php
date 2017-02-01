<?php

namespace EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmailBundle\Entity\Traits\IdTrait;
use EmailBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="email_template")
 */
class EmailTemplate
{
    use IdTrait, TimestampableTrait;

    /**
     * @ORM\OneToMany(targetEntity="EmailUser", mappedBy="user", cascade={"remove"}, orphanRemoval=true)
     */
    private $users;

    /**
     * @param EmailUser $user
     */
    public function addUser(EmailUser $user)
    {
        $this->users->add($user);
    }

    /**
     * @param EmailUser $user
     */
    public function removeUser(EmailUser $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users->toArray();
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
}
