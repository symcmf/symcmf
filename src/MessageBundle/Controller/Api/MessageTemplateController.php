<?php

namespace MessageBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\View;
use MessageBundle\Model\MessageTemplateInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MessageTemplateController
 * @package MessageBundle\Controller\Api
 */
class MessageTemplateController
{
    /**
     * @var MessageTemplateInterface
     */
    private $messageTemplateManager;

    /**
     * MessageTemplateController constructor.
     * @param MessageTemplateInterface $messageTemplateManager
     */
    public function __construct(MessageTemplateInterface $messageTemplateManager)
    {
        $this->messageTemplateManager = $messageTemplateManager;
    }

    /**
     * Retrieves a specific page.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="page id"}
     *  },
     *  output={"class"="Message\Model\MessageTemplateInterface", "groups"="sonata_api_read"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when message template is not found"
     *  }
     * )
     *
     * @View(serializerGroups="sonata_api_read", serializerEnableMaxDepthChecks=true)
     *
     * @param $id
     *
     * @return MessageTemplateInterface
     */
    public function getMessageTemplateAction($id)
    {
        return $this->getMessageTemplate($id);
    }

    public function getMessageTemplate($id)
    {
        $template = $this->messageTemplateManager->find($id);

        if (!$template) {
            throw new NotFoundHttpException(sprintf('Message template (%d) not found', $id));
        }

        return $template;
    }
}
