<?php

namespace NixMailerBundle\Services;

use FOS\UserBundle\Mailer\Mailer;

/**
 * Class NixMailerService
 * @package AppBundle\Services
 */
class NixMailerService extends Mailer
{
    /**
     * Configuration for nix server
     */
    const MAIL_HEADER_PROJECT = 'symfony-cmf';
    const MAIL_HEADER_EMAILS = 'anastasiya.duchkina@nixsolutions.com, troyan.dmitriy@nixsolutions.com,';
    const MAIL_HEADER_EXTERNAL = '{true}';

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

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);

        $headers = $message->getHeaders();

        $headers->addTextHeader('PROJECT', self::MAIL_HEADER_PROJECT);
        $headers->addTextHeader('EMAILS', self::MAIL_HEADER_EMAILS);
        $headers->addTextHeader('EXTERNAL', self::MAIL_HEADER_EXTERNAL);

        $this->mailer->send($message);
    }
}
