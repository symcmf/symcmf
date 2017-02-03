<?php

namespace Application\Sonata\UserBundle\Security\Core\User;

/**
 * Class FOSSocialSupportTrait
 * @package Application\Sonata\UserBundle\Security\Core\User
 */
trait FOSSocialSupportTrait
{
    /**
     * @var string
     */
    private $setterUid;

    /**
     * @var string
     */
    private $setterName;

    /**
     * @var string
     */
    private $setterData;

    /**
     * Supported social networks
     */
    private function supportedSocial()
    {
        return [
            'facebook',
            'twitter',
            'gplus'
        ];
    }

    /**
     * @param $service
     *
     * @return string
     */
    private function renameGoogleService($service)
    {
        if ($service === 'google') {
            return 'gplus';
        }
        return $service;
    }

    /**
     * @param $user
     * @param $uid
     * @param $name
     * @param $token
     *
     * @return mixed
     */
    public function setSocialKeysOld($user, $uid = null, $name = null, $token =null)
    {
        $user->{$this->setterUid}($uid);
        $user->{$this->setterName}($name);
        $user->{$this->setterData}($token);
        return $user;
    }

    /**
     * Get name of setters for old standard
     */
    public function getSocialKeysOld($service)
    {
        $service = $this->renameGoogleService($service);
        if (in_array($service, $this->supportedSocial())) {
            $setter = 'set' . ucfirst($service);
            $this->setterUid  = $setter . 'Uid';
            $this->setterName = $setter . 'Name';
            $this->setterData = $setter . 'Data';
        }
    }
}
