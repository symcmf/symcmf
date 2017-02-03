<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use MessageBundle\Entity\MessageUser;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
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
    public function removeMessagesUser(MessageUser $messageUser)
    {
        $this->messageUser->removeElement($messageUser);
    }

    /**
     * @return array
     */
    public function getMessageUsers()
    {
        return $this->messageUser->toArray();
    }

    /**
     * @var string $facebookId
     */
    protected $facebookId;

    /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
        $this->salt = '';
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @var string $facebookAccessToken
     */
    protected $facebookAccessToken;

    /**
     * @param $facebookAccessToken
     *
     * @return void
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;
    }

    /**
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * @var string $googleId
     */
    protected $googleId;

    /**
     * @param $googleId
     *
     * @return void
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
        $this->setUsername($googleId);
        $this->salt = '';
    }

    /**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @var string $googleAccessToken
     */
    protected $googleAccessToken;

    /**
     * @param $googleAccessToken
     *
     * @return void
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->googleAccessToken = $googleAccessToken;
    }

    /**
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->googleAccessToken;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->username . ' (' . $this->email . ') ';
    }
}
