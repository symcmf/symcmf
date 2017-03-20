<?php


use Application\Sonata\PageBundle\Controller\Api\PageController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View as FOSRestView;

class PageControllerTest extends \Codeception\Test\Unit
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

    public function testGetPagesAction()
    {
        $pager = $this->getMockBuilder('Sonata\AdminBundle\Datagrid\Pager')->disableOriginalConstructor()->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();

        $pageManager->expects($this->once())->method('getPager')->will($this->returnValue($pager));

        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->setMethods(['addParam', 'setController', 'get', 'all'])
            ->getMock();

        $paramFetcher->expects($this->once())->method('addParam');
        $paramFetcher->expects($this->exactly(3))->method('get');
        $paramFetcher->expects($this->once())->method('all')->will($this->returnValue(array()));

        $this->assertSame($pager, $this->createPageController(null, null, $pageManager)->getPagesAction($paramFetcher));
    }

    public function testGetPageAction()
    {
        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $this->assertEquals($page, $this->createPageController($page)->getPageAction(1));
    }

    /**
     * @expectedException        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Page (42) not found
     */
    public function testGetPageActionNotFoundException()
    {
        $this->createPageController()->getPageAction(42);
    }

    public function testGetPageBlocksAction()
    {
        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();
        $block = $this->getMockBuilder('Sonata\PageBundle\Model\PageBlockInterface')->getMock();

        $page->expects($this->once())->method('getBlocks')->will($this->returnValue(array($block)));

        $this->assertEquals(array($block), $this->createPageController($page)->getPageBlocksAction(1));
    }

    public function testPostPageAction()
    {
        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();
        $pageManager->expects($this->once())->method('save')->will($this->returnValue($page));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(true));
        $form->expects($this->once())->method('getData')->will($this->returnValue($page));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createPageController(null, null, $pageManager, null, $formFactory)->postPageAction(new Request());

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPostPageInvalidAction()
    {
        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();
        $pageManager->expects($this->never())->method('save')->will($this->returnValue($page));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createPageController(null, null, $pageManager, null, $formFactory)->postPageAction(new Request());

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $view);
    }

    public function testPutPageAction()
    {
        $page = $this->getMockBuilder('Sonata\UserBundle\Model\PageInterface')->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();
        $pageManager->expects($this->once())->method('save')->will($this->returnValue($page));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(true));
        $form->expects($this->once())->method('getData')->will($this->returnValue($page));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createPageController($page, null, $pageManager, null, $formFactory)->putPageAction(1, new Request());

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPutPageInvalidAction()
    {
        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();
        $pageManager->expects($this->never())->method('save')->will($this->returnValue($page));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createPageController($page, null, $pageManager, null, $formFactory)->putPageAction(1, new Request());

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $view);
    }

    public function testDeletePageAction()
    {
        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();
        $pageManager->expects($this->once())->method('delete');

        $view = $this->createPageController($page, null, $pageManager)->deletePageAction(1);

        $this->assertEquals(array('deleted' => true), $view);
    }

    public function testDeletePageInvalidAction()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();
        $pageManager->expects($this->never())->method('delete');

        $this->createPageController(null, null, $pageManager)->deletePageAction(1);
    }

    public function testPostPageBlockAction()
    {
        $block = $this->getMockBuilder('Sonata\PageBundle\Model\Block')->getMock();
        $block->expects($this->once())->method('setPage');

        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();

        $blockManager = $this->getMockBuilder('Sonata\BlockBundle\Model\BlockManagerInterface')->getMock();
        $blockManager->expects($this->once())->method('save')->will($this->returnValue($block));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(true));
        $form->expects($this->once())->method('getData')->will($this->returnValue($block));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createPageController($page, null, $pageManager, $blockManager, $formFactory)->postPageBlockAction(1, new Request());

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPostPageBlockInvalidAction()
    {
        $block = $this->getMockBuilder('Sonata\PageBundle\Model\Block')->getMock();

        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();

        $blockManager = $this->getMockBuilder('Sonata\BlockBundle\Model\BlockManagerInterface')->getMock();
        $blockManager->expects($this->never())->method('save')->will($this->returnValue($block));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createPageController($page, null, $pageManager, $blockManager, $formFactory)->postPageBlockAction(1, new Request());

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $view);
    }

    public function testPostPageSnapshotAction()
    {
        $page = $this->getMockBuilder('Sonata\PageBundle\Model\PageInterface')->getMock();

        $backend = $this->getMockBuilder('Sonata\NotificationBundle\Backend\BackendInterface')->getMock();
        $backend->expects($this->once())->method('createAndPublish');

        $view = $this->createPageController($page, null, null, null, null, $backend)->postPageSnapshotAction(1);

        $this->assertEquals(array('queued' => true), $view);
    }

    public function testPostPagesSnapshotsAction()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->once())->method('findAll')->will($this->returnValue(array($site)));

        $backend = $this->getMockBuilder('Sonata\NotificationBundle\Backend\BackendInterface')->getMock();
        $backend->expects($this->once())->method('createAndPublish');

        $view = $this->createPageController(null, $siteManager, null, null, null, $backend)->postPagesSnapshotsAction();

        $this->assertEquals(array('queued' => true), $view);
    }

    public function testSerializeContext()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $result = $this->createPageController()->serializeContext($site, []);
        $this->assertInstanceOf(FOSRestView::class, $result);
    }

    /**
     * @param $page
     * @param $siteManager
     * @param $pageManager
     * @param $blockManager
     * @param $formFactory
     * @param $backend
     *
     * @return PageController
     */
    public function createPageController($page = null, $siteManager = null, $pageManager = null, $blockManager = null, $formFactory = null, $backend = null)
    {
        if (null === $siteManager) {
            $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        }
        if (null === $pageManager) {
            $pageManager = $this->getMockBuilder('Sonata\PageBundle\Model\PageManagerInterface')->getMock();
        }
        if (null === $blockManager) {
            $blockManager = $this->getMockBuilder('Sonata\BlockBundle\Model\BlockManagerInterface')->getMock();
        }
        if (null !== $page) {
            $pageManager->expects($this->once())->method('findOneBy')->will($this->returnValue($page));
        }
        if (null === $formFactory) {
            $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        }
        if (null === $backend) {
            $backend = $this->getMockBuilder('Sonata\NotificationBundle\Backend\BackendInterface')->getMock();
        }

        return new PageController($siteManager, $pageManager, $blockManager, $formFactory, $backend);
    }
}