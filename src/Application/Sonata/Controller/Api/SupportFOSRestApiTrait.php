<?php
namespace Application\Sonata\Controller\Api;

use FOS\RestBundle\Context\Context;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\View\View as FOSRestView;

trait SupportFOSRestApiTrait
{
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
