<?php

namespace Application\Sonata\NewsBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\NewsBundle\Model\Comment;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\NewsBundle\Controller\Api\CommentController as ParentController;

/**
 * Class CommentController
 * @package Application\Sonata\NewsBundle\Controller\Api
 */
class CommentController extends ParentController
{
    /**
     * Retrieves a specific comment.
     *
     * @ApiDoc(
     *  resource=true,
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="comment id"}
     *  },
     *  output={"class"="Sonata\NewsBundle\Model\Comment", "groups"="sonata_api_read"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when comment is not found"
     *  }
     * )
     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id A comment identifier
     *
     * @return Comment
     *
     * @throws NotFoundHttpException
     */
    public function getCommentAction($id)
    {
        return parent::getCommentAction($id);
    }
}
