<?php

namespace MessageBundle\Controller\Api;

use Application\Sonata\Controller\Api\SupportFOSRestApiTrait;
use Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\UserBundle\Model\UserManager;
use MessageBundle\Entity\MessageTemplateManager;
use MessageBundle\Entity\MessageUser;
use MessageBundle\Entity\MessageUserManager;
use MessageBundle\Model\MessageUserInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RuntimeException;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View as FOSRestView;

/**
 * Class MessageTemplateController
 * @package MessageBundle\Controller\Api
 */
class MessageUserController
{
    use SupportFOSRestApiTrait;

    /**
     * @var MessageUserInterface
     */
    private $messageUserManager;

    /**
     * @var MessageTemplateManager
     */
    private $messageTemplateManager;

    /**
     * @var UserManager
     */
    private $userManager;


    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * MessageTemplateController constructor.
     * @param MessageUserManager $messageUserManager
     * @param MessageTemplateManager $messageTemplateManager
     * @param UserManager $userManager
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        MessageUserManager $messageUserManager,
        MessageTemplateManager $messageTemplateManager,
        UserManager $userManager,
        FormFactoryInterface $formFactory)
    {
        $this->messageUserManager = $messageUserManager;
        $this->messageTemplateManager = $messageTemplateManager;
        $this->userManager = $userManager;
        $this->formFactory = $formFactory;
    }


    /**
     * Returns a paginated list of sent messages
     *
     * @ApiDoc(
     *  resource=true,
     *  output={"class"="Sonata\DatagridBundle\Pager\PagerInterface", "groups"={"sonata_api_read"}}
     * )
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page for entities list pagination (1-indexed)")
     * @QueryParam(name="count", requirements="\d+", default="10", description="Number of entities by page")

     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return PagerInterface
     */
    public function getMessagesAction(ParamFetcherInterface $paramFetcher)
    {
        $page = $paramFetcher->get('page');
        $limit = $paramFetcher->get('count');
        $criteria = $paramFetcher->all();
        return $this->messageUserManager->getPager($criteria, $page, $limit);
    }


    /**
     * Retrieves a specific sent message
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="send message id"}
     *  },
     *  output={"class"="Message\Model\MessageUserInterface", "groups"="sonata_api_read"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when message template is not found"
     *  }
     * )
     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @param $id
     *
     * @return MessageUserInterface
     *
     * @throws NotFoundHttpException
     */
    public function getMessageAction($id)
    {
        return $this->getMessageUser($id);
    }

    /**
     * @param $id
     *
     * @return MessageUserInterface
     *
     * @throws NotFoundHttpException
     */
    private function getMessageUser($id)
    {
        $messageUser = $this->messageUserManager->find($id);

        if (!$messageUser) {
            throw new NotFoundHttpException(sprintf('Sent message (%d) not found', $id));
        }

        return $messageUser;
    }

    /**
     * Attach a message to a user.
     *
     * @ApiDoc(
     *  requirements={
     *     {"name"="messageId", "dataType"="integer", "requirement"="\d+", "description"="message template identifier"},
     *     {"name"="userId", "dataType"="integer", "requirement"="\d+", "description"="user identifier"}
     *  },
     *  output={"class"="Message\Model\MessageUserInterface", "groups"={"sonata_api_read"}},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while message/user attachment",
     *      404="Returned when unable to find message or user"
     *  }
     * )
     *
     * @param int $messageId A Message template identifier
     * @param int $userId  A User identifier
     *
     * @return FOSRestView
     *
     * @throws NotFoundHttpException
     * @throws RuntimeException
     */

    public function postMessageTemplateUserAction($messageId, $userId)
    {
        $messageTemplate = $this->messageTemplateManager->find($messageId);

        if (!$messageTemplate) {
            return FOSRestView::create(array(
                'error' => sprintf('Message template %d not found ', $messageId),
            ), 404);
        }

        $user = $this->userManager->findUserBy(['id' => $userId]);
        if (!$user) {
            return FOSRestView::create(array(
                'error' => sprintf('User %d not found ', $userId),
            ), 404);
        }

        $messageUser = new MessageUser();
        $messageUser->setUser($user);
        $messageUser->setMessage($messageTemplate);
        $this->messageUserManager->save($messageUser);
        return $this->serializeContext($messageUser, ['sonata_api_read']);
    }

    /**
     * Deletes a row about sent message
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="sent message identifier"}
     *  },
     *  statusCodes={
     *      200="Returned when message template is successfully deleted",
     *      400="Returned when an error has occurred while message template deletion",
     *      404="Returned when unable to find message template"
     *  }
     * )
     *
     * @param int $id A sent message identifier
     *
     * @return FOSRestView
     *
     * @throws NotFoundHttpException
     */
    public function deleteMessageAction($id)
    {
        $message = $this->getMessageUser($id);

        try {
            $this->messageUserManager->delete($message);
        } catch (Exception $e) {
            return FOSRestView::create(['error' => $e->getMessage()], 400);
        }

        return ['deleted' => true];
    }
}
