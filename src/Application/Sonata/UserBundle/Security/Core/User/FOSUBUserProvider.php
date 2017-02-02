<?php

namespace Application\Sonata\UserBundle\Security\Core\User;

use Symfony\Component\Security\Core\User\UserInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;

/**
 * Class FOSUserProvider
 * @package Application\Sonata\UserBundle\Security\Core\User
 */
class FOSUBUserProvider extends BaseClass
{
    /**
     * Name of social network
     *
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $setterId;

    /**
     * @var string
     */
    private $setterToken;

    /**
     * Set client id and token for user
     *
     * @param $user - UserInterface
     * @param $id - social id
     * @param $token - secret token
     *
     * @return UserInterface
     */
    private function setSocialKeys($user, $id = null, $token = null)
    {
        $user->{$this->setterId}($id);
        $user->{$this->setterToken}($token);
        return $user;
    }

    /**
     * Function for getting names of methods
     * in Entity for social network, which was gotten from response
     *
     * @return void
     */
    private function getSocialAliases()
    {
        $setter = 'set' . ucfirst($this->service);
        $this->setterId = $setter . 'Id';
        $this->setterToken = $setter . 'AccessToken';
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $this->service = $response->getResourceOwner()->getName();
        $property = $this->getProperty($response);
        $username = $response->getUsername();
        //on connect - get the access token and the user ID
        $this->getSocialAliases();
        //we "disconnect" previously connected users
        if (($previousUser = $this->userManager->findUserBy([$property => $username]))) {
            $this->userManager->updateUser($this->setSocialKeys($previousUser));
        }
        $user = $this->setSocialKeys($user, $username, $response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $this->service = $response->getResourceOwner()->getName();
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy([$this->getProperty($response) => $username]);
        // if can't find user with with this id
        if (!$user) {
            $user = $this->userManager->findUserByEmail($response->getEmail());
            // if user was already register
            if ($user) {
                $this->getSocialAliases();
                $user = $this->setSocialKeys($user, $username, $response->getAccessToken());
                $user->setUsername($response->getNickname());
                $this->userManager->updateUser($user);
                return $user;
            }
        }
        if (!$user) {
            $this->getSocialAliases();
            // create new user here
            $user = $this->userManager->createUser();
            // set id and token for new user
            $this->setSocialKeys($user, $username, $response->getAccessToken());
            // set another variables
            $user->setUsername($response->getNickname());
            $user->setEmail($response->getEmail());
            $user->setPassword($username);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);
            return $user;
        }
        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
        $setter = 'set' . ucfirst($this->service) . 'AccessToken';
        //update access token
        $user->$setter($response->getAccessToken());
        return $user;
    }
}