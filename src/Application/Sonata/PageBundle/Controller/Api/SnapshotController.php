<?php

namespace Application\Sonata\PageBundle\Controller\Api;

use Application\Sonata\Controller\Api\SupportFOSRestApiTrait;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Sonata\PageBundle\Controller\Api\SnapshotController as ParentController;

/**
 * Class SnapshotController
 * @package Application\Sonata\PageBundle\Controller\Api
 */
class SnapshotController extends ParentController
{
    use SupportFOSRestApiTrait;
    /**
     * Retrieves the list of snapshots (paginated).
     *
     * @ApiDoc(
     *  resource=true,
     *  output={"class"="Sonata\DatagridBundle\Pager\PagerInterface", "groups"="sonata_api_read"}
     * )
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page for snapshots list pagination")
     * @QueryParam(name="count", requirements="\d+", default="10", description="Maximum number of snapshots per page")
     * @QueryParam(name="site", requirements="\d+", nullable=true, strict=true, description="Filter snapshots for a specific site's id")
     * @QueryParam(name="page_id", requirements="\d+", nullable=true, strict=true, description="Filter snapshots for a specific page's id")
     * @QueryParam(name="root", requirements="0|1", nullable=true, strict=true, description="Filter snapshots having no parent id")
     * @QueryParam(name="parent", requirements="\d+", nullable=true, strict=true, description="Get snapshots being child of given snapshots id")
     * @QueryParam(name="enabled", requirements="0|1", nullable=true, strict=true, description="Enabled/Disabled snapshots filter")
     * @QueryParam(name="orderBy", requirements="ASC|DESC", nullable=true, strict=true, description="Order by array (key is field, value is direction)")
     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return PagerInterface
     */
    public function getSnapshotsAction(ParamFetcherInterface $paramFetcher)
    {
        $paramFetcher = $this->setOrderByParam($paramFetcher);
        return parent::getSnapshotsAction($paramFetcher);
    }

    /**
     * Retrieves a specific snapshot.
     *
     * @ApiDoc(
     *  resource=true,
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="snapshot id"}
     *  },
     *  output={"class"="Sonata\PageBundle\Model\SnapshotInterface", "groups"="sonata_api_read"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when snapshots is not found"
     *  }
     * )
     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @param $id
     *
     * @return SnapshotInterface
     */
    public function getSnapshotAction($id)
    {
        return parent::getSnapshotAction($id);
    }
}
