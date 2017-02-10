<?php
namespace Application\Sonata\Controller\Api;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\View\View as FOSRestView;

trait SupportFOSRestApiTrait
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return ParamFetcherInterface
     */
    public function setOrderByParam(ParamFetcherInterface $paramFetcher)
    {
        $orderByQueryParam = new QueryParam();
        // support FOSRestApi ^2.0
        if (property_exists($orderByQueryParam, 'map')) {
            $orderByQueryParam->map = true;
        } else {
            // support FOSRestApi 1.7.9
            $orderByQueryParam->array = true;
        }
        $paramFetcher->addParam($orderByQueryParam);
        return $paramFetcher;
    }

    /**
     * @param $object
     * @param array $groups
     *
     * @return FOSRestView
     */
    public function serializeContext($object, array $groups)
    {
        $view = FOSRestView::create($object);
        if (class_exists('FOS\RestBundle\Context\Context')) {
            $context = new Context();
            $context->setGroups($groups);
            $view->setContext($context);
        } else {
            // support FOSRestApi 1.7.9
            $serializationContext = SerializationContext::create();
            $serializationContext->setGroups($groups);
            $serializationContext->enableMaxDepthChecks();
            $view->setSerializationContext($serializationContext);
        }
        return $view;
    }
}
