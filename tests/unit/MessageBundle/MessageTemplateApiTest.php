<?php

use MessageBundle\Controller\Api\MessageTemplateController;
use MessageBundle\Entity\MessageTemplate;
use Symfony\Component\HttpFoundation\Request;

class MessageTemplateApiTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetTemplatesAction()
    {
        $pager = $this->getMockBuilder('Sonata\AdminBundle\Datagrid\Pager')->disableOriginalConstructor()->getMock();

        $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        $messageManager->expects($this->once())->method('getPager')->will($this->returnValue($pager));

        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->setMethods(['addParam', 'setController', 'get', 'all'])
            ->getMock();

        $paramFetcher->expects($this->once())->method('addParam');
        $paramFetcher->expects($this->exactly(3))->method('get');
        $paramFetcher->expects($this->once())->method('all')->will($this->returnValue(array()));

        $this->assertSame($pager, $this->createMessageTemplateController(null, $messageManager)->getTemplatesAction($paramFetcher));
    }

    public function testGetTemplateAction()
    {
        $messageTemplate = new MessageTemplate();
        $this->assertEquals($messageTemplate, $this->createMessageTemplateController($messageTemplate)->getTemplateAction(1));
    }

    /**
     * @expectedException        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Message template (33) not found
     */
    public function testGetTemplateNotFoundException()
    {
        $this->createMessageTemplateController()->getTemplateAction(33);
    }

    public function testPostTemplateAction()
    {
        $messageTemplate = new MessageTemplate();

        $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        $messageManager->expects($this->once())->method('save')->will($this->returnValue($messageTemplate));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(true));
        $form->expects($this->once())->method('getData')->will($this->returnValue($messageTemplate));

        $formFactory =  $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->disableOriginalConstructor()->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createMessageTemplateController(null, $messageManager, $formFactory)->postTemplateAction(new Request());

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPostTemplateInvalidAction()
    {
        $messageTemplate = new MessageTemplate();

        $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        $messageManager->expects($this->never())->method('save')->will($this->returnValue($messageTemplate));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $formFactory =  $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->disableOriginalConstructor()->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createMessageTemplateController(null, $messageManager, $formFactory)->postTemplateAction(new Request());

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $view);
    }

    public function testPutTemplateAction()
    {
        $messageTemplate = new MessageTemplate();

        $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        $messageManager->expects($this->once())->method('save')->will($this->returnValue($messageTemplate));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(true));
        $form->expects($this->once())->method('getData')->will($this->returnValue($messageManager));

        $formFactory =  $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->disableOriginalConstructor()->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createMessageTemplateController($messageTemplate, $messageManager, $formFactory)->putTemplateAction(1, new Request());

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPutTemplateInvalidAction()
    {
        $messageTemplate = new MessageTemplate();

        $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        $messageManager->expects($this->never())->method('save')->will($this->returnValue($messageTemplate));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $formFactory =  $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->disableOriginalConstructor()->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createMessageTemplateController($messageTemplate, $messageManager, $formFactory)->putTemplateAction(1, new Request());

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $view);
    }


    public function testDeleteTemplateAction()
    {
        $messageTemplate = new MessageTemplate();

        $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        $messageManager->expects($this->once())->method('delete');

        $view = $this->createMessageTemplateController($messageTemplate, $messageManager)->deleteTemplateAction(1);

        $this->assertEquals(['deleted' => true], $view);
    }

    public function testDeleteTemplateInvalidAction()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');

        $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        $messageManager->expects($this->never())->method('delete');

        $this->createMessageTemplateController(null, $messageManager)->deleteTemplateAction(1);
    }

    public function createMessageTemplateController($messageTemplate = null, $messageManager = null, $formFactory = null)
    {
        if (null === $messageManager) {
            $messageManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        }

        if (null !== $messageTemplate) {
            $messageManager->expects($this->once())->method('find')->will($this->returnValue($messageTemplate));
        }
        if (null === $formFactory) {
            $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->disableOriginalConstructor()->getMock();
        }

        return new MessageTemplateController($messageManager, $formFactory);
    }
}
