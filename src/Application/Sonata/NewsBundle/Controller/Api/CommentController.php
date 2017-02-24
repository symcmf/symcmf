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

    /**
     * Deletes a comment.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="comment identifier"}
     *  },
     *  statusCodes={
     *      200="Returned when comment is successfully deleted",
     *      400="Returned when an error has occurred while comment deletion",
     *      404="Returned when unable to find comment"
     *  }
     * )
     *
     * @param int $id A comment identifier
     *
     * @return View
     *
     * @throws NotFoundHttpException
     */
    public function deleteCommentAction($id)
    {
        return parent::deleteCommentAction($id);
    }
}
