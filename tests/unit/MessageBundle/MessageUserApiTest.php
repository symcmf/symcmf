<?php

use MessageBundle\Controller\Api\MessageUserController;
use MessageBundle\Entity\MessageTemplate;
use FOS\RestBundle\View\View as FOSRestView;

class MessageUserApiTest extends \Codeception\Test\Unit
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

    public function testGetMessagesAction()
    {
        $pager = $this->getMockBuilder('Sonata\AdminBundle\Datagrid\Pager')->disableOriginalConstructor()->getMock();

        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUserManager')->disableOriginalConstructor()->getMock();
        $manager->expects($this->once())->method('getPager')->will($this->returnValue($pager));

        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->getMock();

        $paramFetcher->expects($this->exactly(2))->method('get');
        $paramFetcher->expects($this->once())->method('all')->will($this->returnValue(array()));

        $this->assertSame($pager, $this->createMessageUserController(null, $manager)->getMessagesAction($paramFetcher));
    }

    public function testGetMessageAction()
    {
        $messageUser = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->disableOriginalConstructor()
            ->getMock();
        $this->assertEquals($messageUser, $this->createMessageUserController($messageUser)->getMessageAction(1));
    }

    /**
     * @expectedException        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Sent message (33) not found
     */
    public function testGetMessageNotFoundException()
    {
        $this->createMessageUserController()->getMessageAction(33);
    }

    public function testPostTemplateAction()
    {
        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUserManager')
            ->disableOriginalConstructor()->getMock();
        $manager->expects($this->once())->method('save');


        $template = new MessageTemplate();
        $user = $this->getMockBuilder('Application\Sonata\UserBundle\Entity\User')->disableOriginalConstructor()->getMock();

        $view = $this->createMessageUserController(null, $manager, $template, null, $user, null)->postMessageTemplateUserAction(1,1);

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPostTemplateInvalidAction()
    {
        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUserManager')
            ->disableOriginalConstructor()->getMock();
        $manager->expects($this->never())->method('save');

        $view = $this->createMessageUserController(null, $manager)->postMessageTemplateUserAction(33, 33);

        $response = FOSRestView::create(['error' => sprintf('Message template %d not found ', 33)], 404);

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
        $this->assertEquals($response, $view);
    }

    public function testDeleteMessageAction()
    {
        $messageUser = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUserManager')->disableOriginalConstructor()->getMock();
        $manager->expects($this->once())->method('delete');

        $view = $this->createMessageUserController($messageUser, $manager)->deleteMessageAction(1);

        $this->assertEquals(['deleted' => true], $view);
    }

    public function testDeleteMessageInvalidAction()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');

        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUserManager')->disableOriginalConstructor()->getMock();
        $manager->expects($this->never())->method('delete');

        $this->createMessageUserController(null, $manager)->deleteMessageAction(1);
    }

    public function testSetOrderByParam()
    {
        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->setMethods(['addParam', 'setController', 'get', 'all'])
            ->getMock();
        $paramFetcher->expects($this->any())->method('addParam')->will($this->returnValue($paramFetcher));

        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUserManager')->disableOriginalConstructor()->getMock();

        $result = $this->createMessageUserController(null, $manager)->setOrderByParam($paramFetcher);

        $this->assertEquals($paramFetcher, $result);
    }

    public function testSerializeContext()
    {
        $messageUser = $this
            ->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->createMessageUserController()->serializeContext($messageUser, []);
        $this->assertInstanceOf(FOSRestView::class, $result);
    }


    public function createMessageUserController(
        $messageUser = null,
        $messageUserManager = null,
        $template = null,
        $messageTemplateManager = null,
        $user = null,
        $userManager = null,
        $formFactory = null
    )
    {
        if (null === $messageUserManager) {
            $messageUserManager = $this->getMockBuilder('MessageBundle\Entity\MessageUserManager')->disableOriginalConstructor()->getMock();
        }

        if (null !== $messageUser) {
            $messageUserManager->expects($this->once())->method('find')->will($this->returnValue($messageUser));
        }

        if (null === $messageTemplateManager) {
            $messageTemplateManager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplateManager')->disableOriginalConstructor()->getMock();
        }

        if (null !== $template) {
            $messageTemplateManager->expects($this->once())->method('find')->will($this->returnValue($template));
        }

        if (null === $userManager) {
            $userManager = $this->getMockBuilder('FOS\UserBundle\Model\UserManager')->disableOriginalConstructor()->getMock();
        }

        if (null !== $user) {
            $userManager->expects($this->once())->method('findUserBy')->will($this->returnValue($user));
        }

        if (null === $formFactory) {
            $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->disableOriginalConstructor()->getMock();
        }

        return new MessageUserController($messageUserManager, $messageTemplateManager, $userManager, $formFactory);
    }
}
