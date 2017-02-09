<?php

namespace MessageBundle\Controller\Api;

use Application\Sonata\Controller\Api\SupportFOSRestApiTrait;
use Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use MessageBundle\Entity\MessageTemplateManager;
use MessageBundle\Model\MessageTemplateInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View as FOSRestView;

/**
 * Class MessageTemplateController
 * @package MessageBundle\Controller\Api
 */
class MessageTemplateController
{

    use SupportFOSRestApiTrait;

    /**
     * @var MessageTemplateInterface
     */
    private $messageTemplateManager;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * MessageTemplateController constructor.
     * @param MessageTemplateManager $messageTemplateManager
     */
    public function __construct(MessageTemplateManager $messageTemplateManager, FormFactoryInterface $formFactory)
    {
        $this->messageTemplateManager = $messageTemplateManager;
        $this->formFactory = $formFactory;
    }


    /**
     * Returns a paginated list of message templates.
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
        $orderByQueryParam = new QueryParam();
        $orderByQueryParam->name = 'orderBy';
        $orderByQueryParam->requirements = 'ASC|DESC';
        $orderByQueryParam->nullable = true;
        $orderByQueryParam->strict = true;
        $orderByQueryParam->description = 'Query users order by clause (key is field, value is direction)';
        if (property_exists($orderByQueryParam, 'map')) {
            $orderByQueryParam->map = true;
        } else {
            $orderByQueryParam->array = true;
        }

        $paramFetcher->addParam($orderByQueryParam);

        $page = $paramFetcher->get('page');
        $limit = $paramFetcher->get('count');
        $sort = $paramFetcher->get('orderBy');
        $criteria = $paramFetcher->all();

        foreach ($criteria as $key => $value) {
            if (null === $value) {
                unset($criteria[$key]);
            }
        }

        if (!$sort) {
            $sort = array();
        } elseif (!is_array($sort)) {
            $sort = array($sort, 'asc');
        }

        return $this->messageTemplateManager->getPager($criteria, $page, $limit, $sort);
    }


    /**
     * Retrieves a specific message.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="message id"}
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
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param $id
     *
     * @return MessageTemplateInterface
     *
     * @throws NotFoundHttpException
     */
    public function getMessageAction($id)
    {
        return $this->getMessageTemplate($id);
    }

    /**
     * @param $id
     *
     * @return MessageTemplateInterface
     *
     * @throws NotFoundHttpException
     */
    public function getMessageTemplate($id)
    {
        $template = $this->messageTemplateManager->find($id);

        if (!$template) {
            throw new NotFoundHttpException(sprintf('Message template (%d) not found', $id));
        }

        return $template;
    }

    /**
     * Adds an message template.
     *
     * @ApiDoc(
     *  input={"class"="message_api_form_message", "name"="", "groups"={"sonata_api_write"}},
     *  output={"class"="Message\Model\MessageTemplateInterface", "groups"={"sonata_api_read"}},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while message template creation",
     *  }
     * )
     *
     * @param Request $request A Symfony request
     *
     * @return MessageTemplateInterface
     *
     * @throws NotFoundHttpException
     */
    public function postMessageAction(Request $request)
    {
        return $this->handleWriteMessage($request);
    }

    /**
     * Updates a message template.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="message template id"},
     *  },
     *  input={"class"="message_api_form_message", "name"="", "groups"={"sonata_api_write"}},
     *  output={"class"="Message\Model\MessageTemplateInterface", "groups"={"sonata_api_read"}},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while updating the message template",
     *      404="Returned when unable to find the message template"
     *  }
     * )
     *
     * @param int     $id      A message template identifier
     * @param Request $request A Symfony request
     *
     * @return MessageTemplateInterface
     *
     * @throws NotFoundHttpException
     */
    public function putMessageAction($id, Request $request)
    {
        return $this->handleWriteMessage($request, $id);
    }

    /**
     * Deletes a message template.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="message template identifier"}
     *  },
     *  statusCodes={
     *      200="Returned when message template is successfully deleted",
     *      400="Returned when an error has occurred while message template deletion",
     *      404="Returned when unable to find message template"
     *  }
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id A message template identifier
     *
     * @return FOSRestView
     *
     * @throws NotFoundHttpException
     */
    public function deleteMessageAction($id)
    {
        $message = $this->getMessageTemplate($id);

        try {
            $this->messageTemplateManager->delete($message);
        } catch (Exception $e) {
            return FOSRestView::create(['error' => $e->getMessage()], 400);
        }

        return ['deleted' => true];
    }

    /**
     * Write a site, this method is used by both POST and PUT action methods.
     *
     * @param Request  $request Symfony request
     * @param int|null $id      A post identifier
     *
     * @return FormInterface|FOSRestView
     */
    protected function handleWriteMessage($request, $id = null)
    {
        $messageTemplate = $id ? $this->getMessageTemplate($id) : null;

        $form = $this->formFactory->createNamed(
            null,
            'message_api_form_message',
            $messageTemplate,
            ['csrf_protection' => false]
        );

        $form->submit($request);

        if ($form->isValid()) {
            $messageTemplate = $form->getData();

            $this->messageTemplateManager->save($messageTemplate);
            return $this->serializeContext($messageTemplate, ['sonata_api_read']);
        }
        return $form;
    }
}
