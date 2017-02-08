<?php

namespace MessageBundle\Model;

use FOS\UserBundle\Model\UserInterface;

interface MessageUserInterface
{
    /**
     * @return MessageTemplateInterface,
     */
    public function getMessage();
    /**
     * @param MessageTemplateInterface|null $message
     *
     * @return $this
     */
    public function setMessage(MessageTemplateInterface $message = null);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param UserInterface|null $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user = null);

    /**
     * @return string
     */
    public function __toString();
}
