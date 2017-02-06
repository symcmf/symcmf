<?php

namespace Application\Sonata\UserBundle\Entity;

use Application\Sonata\UserBundle\Model\User as AbstractedUser;
use Sonata\UserBundle\Model\UserInterface;

/**
 * Represents a Base User Entity.
 */
class ApplicationBaseUser extends AbstractedUser
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

    /**
     * Returns the gender list.
     *
     * @return array
     */
    public static function getGenderList()
    {
        return array(
            UserInterface::GENDER_UNKNOWN => 'gender_unknown',
            UserInterface::GENDER_FEMALE => 'gender_female',
            UserInterface::GENDER_MALE => 'gender_male',
        );
    }
}
