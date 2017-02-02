<?php

namespace MessageBundle\Services;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use MessageBundle\Entity\MessageTemplate;
use MessageBundle\Services\Mailers\MailerService;

/**
 * Class MessageService
 * @package MessageBundle\Services
 */
class MessageService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var
     */
    protected $container;

    /**
     * @var MailerService
     */
    protected $mailerService;

    /**
     * EmailService constructor.
     *
     * @param EntityManager $entityManager
     * @param $container
     * @param MailerService $mailerService
     */
    public function __construct(EntityManager $entityManager, $container, MailerService $mailerService)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
        $this->mailerService = $mailerService;
    }

    /**
     * Function for getting all variables from template
     *
     * @param $start
     * @param $end
     * @param $str
     *
     * @return array
     */
    private function getStringBetweenSymbols($start, $end, $str)
    {
        preg_match_all('/' . $start . '(.*?)' . $end . '/', $str, $matches);
        return $matches[1];
    }

    /**
     * @param MessageTemplate $message
     * @param User $user
     *
     * @return string - message with replaced variables
     */
    protected function getMessage(MessageTemplate $message, User $user)
    {
        $template = $message->getTemplate();
        // get all variables from template
        $variables = $this->getStringBetweenSymbols('{{', '}}', $template);
        foreach ($variables as $variable) {
            $getter = 'get' . ucfirst(trim($variable));
            $template = str_replace('{{' . $variable . '}}', $user->$getter(), $template);
        }
        return $template;
    }

    /**
     * @param MessageTemplate $message
     * @param User $user
     *
     * @return bool|int
     */
    public function sendMessage(MessageTemplate $message, User $user)
    {
        if (!$user || !$message) {
            return false;
        }
        $this->mailerService->setMessage(
            $message->getSubject(),
            $user->getEmail(),
            $this->getMessage($message, $user)
        );
        return $this->mailerService->send();
    }
}
