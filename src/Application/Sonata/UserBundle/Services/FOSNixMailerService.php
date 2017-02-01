<?php

namespace Application\Sonata\UserBundle\Services;

use FOS\UserBundle\Mailer\Mailer;
use Swift_Message;

/**
 * Class FOSNixMailerService
 * @package Application\Sonata\UserBundle\Services
 */
class FOSNixMailerService extends Mailer
{
    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = array_shift($renderedLines);
        $body = implode("\n", $renderedLines);

        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);

        $headers = $message->getHeaders();
        $headers->addTextHeader('PROJECT', $this->parameters['header_project']);
        $headers->addTextHeader('EMAILS', $this->parameters['header_emails']);
        $headers->addTextHeader('EXTERNAL', $this->parameters['header_external']);

        $this->mailer->send($message);
    }
}
