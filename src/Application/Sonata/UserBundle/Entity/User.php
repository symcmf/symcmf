<?php

namespace Application\Sonata\UserBundle\Entity;

use EmailBundle\Entity\EmailUser;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Application\Sonata\UserBundle\Entity
 */
class User extends BaseUser
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

    /**
     * @ORM\OneToMany(targetEntity="EmailBundle\Entity\EmailUser", mappedBy="user", cascade={"remove"}, orphanRemoval=true)
     */
    private $emails;

    /**
     * @param EmailUser $email
     */
    public function addEmail(EmailUser $email)
    {
        $this->emails->add($email);
    }

    /**
     * @param EmailUser $email
     */
    public function removeEmail(EmailUser $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * @return array
     */
    public function getEmails()
    {
        return $this->emails->toArray();
    }
}
