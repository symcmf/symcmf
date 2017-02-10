<?php

namespace Application\Sonata\PageBundle\Controller\Api;

use Application\Sonata\Controller\Api\SupportFOSRestApiTrait;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Sonata\PageBundle\Controller\Api\PageController as ParentController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package Application\Sonata\PageBundle\Controller\Api
 */
class PageController extends ParentController
{
    use SupportFOSRestApiTrait;

    /**
     * Retrieves the list of pages (paginated).
     *
     * @ApiDoc(
     *  resource=true,
     *  output={"class"="Sonata\DatagridBundle\Pager\PagerInterface", "groups"="sonata_api_read"}
     * )
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page for 'page' list pagination")
     * @QueryParam(name="count", requirements="\d+", default="10", description="Number of pages by page")
     * @QueryParam(name="enabled", requirements="0|1", nullable=true, strict=true, description="Enabled/Disabled pages filter")
     * @QueryParam(name="edited", requirements="0|1", nullable=true, strict=true, description="Edited/Up to date pages filter")
     * @QueryParam(name="internal", requirements="0|1", nullable=true, strict=true, description="Internal/Exposed pages filter")
     * @QueryParam(name="root", requirements="0|1", nullable=true, strict=true, description="Filter pages having no parent id")
     * @QueryParam(name="site", requirements="\d+", nullable=true, strict=true, description="Filter pages for a specific site's id")
     * @QueryParam(name="parent", requirements="\d+", nullable=true, strict=true, description="Get pages being child of given page id")
     * @QueryParam(name="orderBy", requirements="ASC|DESC", nullable=true, strict=true, description="Order by array (key is field, value is direction)")
     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return PagerInterface
     */
    public function getPagesAction(ParamFetcherInterface $paramFetcher)
    {
        $paramFetcher = $this->setOrderByParam($paramFetcher);
        return parent::getPagesAction($paramFetcher);
    }

    /**
     * Adds a block.
     *
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="page identifier"}
     *  },
     *  input={"class"="sonata_page_api_form_block", "name"="", "groups"={"sonata_api_write"}},
     *  output={"class"="Sonata\PageBundle\Model\Block", "groups"={"sonata_api_read"}},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while block creation",
     *      404="Returned when unable to find page"
     *  }
     * )
     *
     * @param int     $id      A Page identifier
     * @param Request $request A Symfony request
     *
     * @return BlockInterface
     *
     * @throws NotFoundHttpException
     */
    public function postPageBlockAction($id, Request $request)
    {
        $page = $id ? $this->getPage($id) : null;

        $form = $this->formFactory->createNamed(null, 'sonata_page_api_form_block', null, [
            'csrf_protection' => false,
        ]);

        $form->submit($request);

        if ($form->isValid()) {
            $block = $form->getData();
            $block->setPage($page);

            $this->blockManager->save($block);
            return $this->serializeContext($block, ['sonata_api_read']);
        }

        return $form;
    }


    /**
     * Write a page, this method is used by both POST and PUT action methods.
     *
     * @param Request  $request Symfony request
     * @param int|null $id      A page identifier
     *
     * @return FormInterface
     */
    public function handleWritePage($request, $id = null)
    {
        $page = $id ? $this->getPage($id) : null;

        $form = $this->formFactory->createNamed(null, 'sonata_page_api_form_page', $page, [
            'csrf_protection' => false,
        ]);

        $form->submit($request);

        if ($form->isValid()) {
            $page = $form->getData();
            $this->pageManager->save($page);

            return $this->serializeContext($page, ['sonata_api_read']);
        }
        return $form;
    }
}
