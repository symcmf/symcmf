<?php

namespace Application\Sonata\UserBundle\Document;

use Application\Sonata\UserBundle\Model\User as AbstractedUser;
use Sonata\UserBundle\Model\UserInterface;

/**
 * Represents a Base User Entity.
 */
class ApplicationBaseUser extends AbstractedUser implements UserInterface
{
    /**
     * Hook on pre-persist operations.
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Hook on pre-update operations.
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
