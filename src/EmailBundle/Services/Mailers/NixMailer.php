<?php

namespace EmailBundle\Services\Mailers;

use Swift_Mailer;
use Swift_Mime_Message;
use Swift_Transport;

/**
 * Class NixMailer
 * @package EmailBundle\Services\Mailers
 */
class NixMailer extends Swift_Mailer
{
    /**
     * @var string - header with name of project
     */
    private $project;

    /**
     * @var string - header with emails of developers
     */
    private $emails;

    /**
     * @var string - param
     */
    private $external;

    /**
     * NixMailer constructor.
     * @param Swift_Transport $transport
     * @param string|null $project
     * @param string|null $emails
     * @param string|null $external
     */
    public function __construct(Swift_Transport $transport, $project = null, $emails = null, $external = null)
    {
        $this->project = $project;
        $this->emails = $emails;
        $this->external = $external;
        parent::__construct($transport);
    }

    /**
     * @param Swift_Mime_Message $message
     * @param null $failedRecipients
     *
     * @return int
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $headers = $message->getHeaders();
        $headers->addTextHeader('PROJECT', $this->project);
        $headers->addTextHeader('EMAILS', $this->emails);
        $headers->addTextHeader('EXTERNAL', $this->external);

        return parent::send($message, $failedRecipients);
    }
}
