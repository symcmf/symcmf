<?php

namespace Application\Sonata\PageBundle\Controller\Api;

use Application\Sonata\Controller\Api\SupportFOSRestApiTrait;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Sonata\PageBundle\Controller\Api\SiteController as ParentController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View as FOSRestView;

/**
 * Class SiteController
 * @package Application\Sonata\PageBundle\Controller\Api
 */
class SiteController extends ParentController
{
    use SupportFOSRestApiTrait;

    /**
     * Retrieves the list of sites (paginated).
     *
     * @ApiDoc(
     *  resource=true,
     *  output={"class"="Sonata\DatagridBundle\Pager\PagerInterface", "groups"="sonata_api_read"}
     * )
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page for site list pagination")
     * @QueryParam(name="count", requirements="\d+", default="10", description="Maximum number of sites per page")
     * @QueryParam(name="enabled", requirements="0|1", nullable=true, strict=true, description="Enabled/Disabled sites filter")
     * @QueryParam(name="is_default", requirements="0|1", nullable=true, strict=true, description="Default sites filter")
     * @QueryParam(name="orderBy", requirements="ASC|DESC", nullable=true, strict=true, description="Order by array (key is field, value is direction)")
     *
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return PagerInterface
     */
    public function getSitesAction(ParamFetcherInterface $paramFetcher)
    {
        $paramFetcher = $this->setOrderByParam($paramFetcher);
        return parent::getSitesAction($paramFetcher);
    }

    /**
     * Write a site, this method is used by both POST and PUT action methods.
     *
     * @param Request  $request Symfony request
     * @param int|null $id      A post identifier
     *
     * @return FormInterface|FOSRestView
     */
    public function handleWriteSite($request, $id = null)
    {
        $site = $id ? $this->getSite($id) : null;

        $form = $this->formFactory->createNamed(null, 'sonata_page_api_form_site', $site, array(
            'csrf_protection' => false,
        ));

        $form->submit($request);

        if ($form->isValid()) {
            $site = $form->getData();

            $this->siteManager->save($site);
            return $this->serializeContext($site, ['sonata_api_read']);
        }

        return $form;
    }
}
