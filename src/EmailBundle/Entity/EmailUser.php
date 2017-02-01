<?php

namespace EmailBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_user")
 */
class EmailUser
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="EmailTemplate", inversedBy="EmailUser")
     * @ORM\JoinColumn(name="email_id", referencedColumnName="id", nullable=false)
     */
    protected $email;

    /**
     * @return EmailTemplate
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param EmailTemplate|null $email
     *
     * @return $this
     */
    public function addEmail(EmailTemplate $email = null)
    {
        if ($this->email !== null) {
            $this->email->removeUser($this);
        }
        if ($email !== null) {
            $email->addUser($this);
        }
        $this->email = $email;
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
