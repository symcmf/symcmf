<?php

namespace Application\Sonata\PageBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Sonata\PageBundle\Controller\Api\PageController as ParentController;

/**
 * Class PageController
 * @package Application\Sonata\PageBundle\Controller\Api
 */
class PageController extends ParentController
{
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
     * @QueryParam(name="orderBy", requirements="ASC|DESC", map=true, nullable=true, strict=true, description="Order by array (key is field, value is direction)")
     *
     * @View(serializerGroups="sonata_api_read", serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return PagerInterface
     */
    public function getPagesAction(ParamFetcherInterface $paramFetcher)
    {
        return parent::getPagesAction($paramFetcher);
    }
}
