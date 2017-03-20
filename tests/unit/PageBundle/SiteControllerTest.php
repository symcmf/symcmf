<?php


use Application\Sonata\PageBundle\Controller\Api\SiteController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View as FOSRestView;

class SiteControllerTest extends \Codeception\Test\Unit
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

    public  function testGetSitesAction()
    {
        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->once())->method('getPager')->will($this->returnValue(array()));
        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->setMethods(array('addParam', 'setController', 'get', 'all'))
            ->getMock();
        $paramFetcher->expects($this->once())->method('addParam');
        $paramFetcher->expects($this->exactly(3))->method('get');
        $paramFetcher->expects($this->once())->method('all')->will($this->returnValue(array()));
        $this->assertEquals(array(), $this->createSiteController(null, $siteManager)->getSitesAction($paramFetcher));
    }

    /**
     * @expectedException        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Site (1) not found
     */
    public function testGetSiteActionNotFoundException()
    {
        $this->createSiteController()->getSiteAction(1);
    }

    public function testPostSiteAction()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->once())->method('save')->will($this->returnValue($site));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(true));
        $form->expects($this->once())->method('getData')->will($this->returnValue($site));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createSiteController(null, $siteManager, $formFactory)->postSiteAction(new Request());

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPostSiteInvalidAction()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->never())->method('save')->will($this->returnValue($site));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createSiteController(null, $siteManager, $formFactory)->postSiteAction(new Request());

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $view);
    }

    public function testPutSiteAction()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->once())->method('save')->will($this->returnValue($site));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(true));
        $form->expects($this->once())->method('getData')->will($this->returnValue($site));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createSiteController($site, $siteManager, $formFactory)->putSiteAction(1, new Request());

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);
    }

    public function testPutSiteInvalidAction()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->never())->method('save')->will($this->returnValue($site));

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('submit');
        $form->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        $formFactory->expects($this->once())->method('createNamed')->will($this->returnValue($form));

        $view = $this->createSiteController($site, $siteManager, $formFactory)->putSiteAction(1, new Request());

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $view);
    }

    public function testDeleteSiteAction()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->once())->method('delete');

        $view = $this->createSiteController($site, $siteManager)->deleteSiteAction(1);

        $this->assertEquals(array('deleted' => true), $view);
    }

    public function testDeleteSiteInvalidAction()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        $siteManager->expects($this->never())->method('delete');

        $this->createSiteController(null, $siteManager)->deleteSiteAction(1);
    }

    public function testSetOrderByParam()
    {
        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->setMethods(['addParam', 'setController', 'get', 'all'])
            ->getMock();
        $paramFetcher->expects($this->any())->method('addParam')->will($this->returnValue($paramFetcher));

        $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();

        $result = $this->createSiteController(null, $siteManager)->setOrderByParam($paramFetcher);

        $this->assertEquals($paramFetcher, $result);
    }

    public function testSerializeContext()
    {
        $site = $this->getMockBuilder('Sonata\PageBundle\Model\SiteInterface')->getMock();

        $result = $this->createSiteController()->serializeContext($site, []);
        $this->assertInstanceOf(FOSRestView::class, $result);
    }

    /**
     * @param $site
     * @param $siteManager
     * @param $formFactory
     *
     * @return SiteController
     */
    public function createSiteController($site = null, $siteManager = null, $formFactory = null)
    {
        if (null === $siteManager) {
            $siteManager = $this->getMockBuilder('Sonata\PageBundle\Model\SiteManagerInterface')->getMock();
        }
        if (null !== $site) {
            $siteManager->expects($this->once())->method('findOneBy')->will($this->returnValue($site));
        }
        if (null === $formFactory) {
            $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactoryInterface')->getMock();
        }

        return new SiteController($siteManager, $formFactory);
    }
}