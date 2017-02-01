<?php

namespace EmailBundle\Services\Mailers;

use Swift_Mime_Message;

/**
 * Class MailerService
 * @package EmailBundle\Services
 */
class NixMailerService extends MailerService
{
    /**
     * @return Swift_Mime_Message
     */
    public function getMessage()
    {
        $message = parent::getMessage();
        $headers = $message->getHeaders();
        $headers->addTextHeader('PROJECT', $this->parameters['header_project']);
        $headers->addTextHeader('EMAILS', $this->parameters['header_emails']);
        $headers->addTextHeader('EXTERNAL', $this->parameters['header_external']);

        return $message;
    }
}
