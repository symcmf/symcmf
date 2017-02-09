<?php

namespace Application\Sonata\NewsBundle\Controller\Api;

use Application\Sonata\Controller\Api\SupportFOSRestApiTrait;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Sonata\NewsBundle\Model\Comment;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\NewsBundle\Controller\Api\PostController as ParentController;

/**
 * Class PostController
 * @package Application\Sonata\NewsBundle\Controller\Api
 */
class PostController extends ParentController
{
    use SupportFOSRestApiTrait;

    /**
     * Retrieves the list of posts (paginated) based on criteria.
     *
     * @ApiDoc(
     *  resource=true,
     *  output={"class"="Sonata\DatagridBundle\Pager\PagerInterface", "groups"={"sonata_api_read"}}
     * )
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page for posts list pagination")
     * @QueryParam(name="count", requirements="\d+", default="10", description="Number of posts by page")
     * @QueryParam(name="enabled", requirements="0|1", nullable=true, strict=true, description="Enabled/Disabled posts filter")
     * @QueryParam(name="dateQuery", requirements=">|<|=", default=">", description="Date filter orientation (>, < or =)")
     * @QueryParam(name="dateValue", requirements="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-2][0-9]:[0-5][0-9]:[0-5][0-9]([+-][0-9]{2}(:)?[0-9]{2})?", nullable=true, strict=true, description="Date filter value")
     * @QueryParam(name="tag", requirements="\S+", nullable=true, strict=true, description="Tag name filter")
     * @QueryParam(name="author", requirements="\S+", nullable=true, strict=true, description="Author filter")
     * @QueryParam(name="mode", requirements="public|admin", default="public", description="'public' mode filters posts having enabled tags and author")
     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return PagerInterface
     */
    public function getPostsAction(ParamFetcherInterface $paramFetcher)
    {
        parent::getPostsAction($paramFetcher);
    }

    /**
     * Adds a comment to a post.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="post id"}
     *  },
     *  input={"class"="sonata_news_api_form_comment", "name"="", "groups"={"sonata_api_write"}},
     *  output={"class"="Sonata\NewsBundle\Model\Comment", "groups"={"sonata_api_read"}},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while comment creation",
     *      403="Returned when commenting is not enabled on the related post",
     *      404="Returned when post is not found"
     *  }
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int     $id      A post identifier
     * @param Request $request
     *
     * @return Comment|FormInterface
     *
     * @throws HttpException
     */
    public function postPostCommentsAction($id, Request $request)
    {
        $post = $this->getPost($id);

        if (!$post->isCommentable()) {
            throw new HttpException(403, sprintf('Post (%d) not commentable', $id));
        }

        $comment = $this->commentManager->create();
        $comment->setPost($post);

        $form = $this->formFactory->createNamed(
            null,
            'sonata_news_api_form_comment',
            $comment,
            ['csrf_protection' => false]
        );
        $form->bind($request);

        if ($form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);

            if (!$comment->getStatus()) {
                $comment->setStatus($post->getCommentsDefaultStatus());
            }

            $this->commentManager->save($comment);
            $this->mailer->sendCommentNotification($comment);
            return $this->serializeContext($comment);
        }

        return $form;
    }

    /**
     * Updates a comment.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="postId", "dataType"="integer", "requirement"="\d+", "description"="post identifier"},
     *      {"name"="commentId", "dataType"="integer", "requirement"="\d+", "description"="comment identifier"}
     *  },
     *  input={"class"="sonata_news_api_form_comment", "name"="", "groups"={"sonata_api_write"}},
     *  output={"class"="Sonata\NewsBundle\Model\Comment", "groups"={"sonata_api_read"}},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while comment update",
     *      404="Returned when unable to find comment"
     *  }
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int     $postId    A post identifier
     * @param int     $commentId A comment identifier
     * @param Request $request   A Symfony request
     *
     * @return Comment
     *
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function putPostCommentsAction($postId, $commentId, Request $request)
    {
        $post = $this->getPost($postId);

        if (!$post->isCommentable()) {
            throw new HttpException(403, sprintf('Post (%d) not commentable', $postId));
        }

        $comment = $this->commentManager->find($commentId);

        if (null === $comment) {
            throw new NotFoundHttpException(sprintf('Comment (%d) not found', $commentId));
        }

        $comment->setPost($post);

        $form = $this->formFactory->createNamed(
            null,
            'sonata_news_api_form_comment',
            $comment,
            ['csrf_protection' => false]
        );

        $form->bind($request);

        if ($form->isValid()) {
            $comment = $form->getData();
            $this->commentManager->save($comment);
            return $this->serializeContext($comment);
        }

        return $form;
    }

    /**
     * Write a post, this method is used by both POST and PUT action methods.
     *
     * @param Request  $request Symfony request
     * @param int|null $id      A post identifier
     *
     * @return FormInterface
     */
    protected function handleWritePost($request, $id = null)
    {
        $post = $id ? $this->getPost($id) : null;

        $form = $this->formFactory->createNamed(
            null,
            'sonata_news_api_form_post',
            $post,
            ['csrf_protection' => false]
        );

        $form->bind($request);

        if ($form->isValid()) {
            $post = $form->getData();
            $post->setContent($this->formatterPool->transform($post->getContentFormatter(), $post->getRawContent()));
            $this->postManager->save($post);

            return $this->serializeContext($post);
        }

        return $form;
    }
}
