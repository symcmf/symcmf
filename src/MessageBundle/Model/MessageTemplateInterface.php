<?php

namespace MessageBundle\Model;

interface MessageTemplateInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * Set title.
     *
     * @param string $title
     */
    public function setSubject($title);

    /**
     * Get title.
     *
     * @return string $title
     */
    public function getSubject();

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate();

    /**
     * Set template
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template);

    /**
     * @param MessageUserInterface $messageUser
     */
    public function addMessageUser(MessageUserInterface $messageUser);

    /**
     * @param MessageUserInterface $messageUser
     */
    public function removeMessageUser(MessageUserInterface $messageUser);
    /**
     * @return array
     */
    public function getMessageUser();

    /**
     * @return string
     */
    public function __toString();
}
