<?php


use Application\Sonata\PageBundle\Controller\Api\SnapshotController;

class SnapshotControlleTest extends \Codeception\Test\Unit
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

    public function testGetSnapshotsAction()
    {
        $snapshotManager = $this->getMockBuilder('Sonata\PageBundle\Model\SnapshotManagerInterface')->getMock();
        $snapshotManager->expects($this->once())->method('getPager')->will($this->returnValue(array()));
        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->setMethods(array('addParam', 'setController', 'get', 'all'))
            ->getMock();
        $paramFetcher->expects($this->once())->method('addParam');
        $paramFetcher->expects($this->exactly(3))->method('get');
        $paramFetcher->expects($this->once())->method('all')->will($this->returnValue(array()));
        $this->assertEquals(array(), $this->createSnapshotController(null, $snapshotManager)->getSnapshotsAction($paramFetcher));
    }

    public function testGetSnapshotAction()
    {
        $snapshot = $this->getMockBuilder('Sonata\PageBundle\Model\SnapshotInterface')->getMock();

        $this->assertEquals($snapshot, $this->createSnapshotController($snapshot)->getSnapshotAction(1));
    }

    /**
     * @expectedException        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Snapshot (1) not found
     */
    public function testGetSnapshotActionNotFoundException()
    {
        $this->createSnapshotController()->getSnapshotAction(1);
    }

    public function testDeleteSnapshotAction()
    {
        $snapshot = $this->getMockBuilder('Sonata\PageBundle\Model\SnapshotInterface')->getMock();

        $snapshotManager = $this->getMockBuilder('Sonata\PageBundle\Model\SnapshotManagerInterface')->getMock();
        $snapshotManager->expects($this->once())->method('delete');

        $view = $this->createSnapshotController($snapshot, $snapshotManager)->deleteSnapshotAction(1);

        $this->assertEquals(['deleted' => true], $view);
    }

    public function testDeletePageInvalidAction()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');

        $snapshotManager = $this->getMockBuilder('Sonata\PageBundle\Model\SnapshotManagerInterface')->getMock();
        $snapshotManager->expects($this->never())->method('delete');

        $this->createSnapshotController(null, $snapshotManager)->deleteSnapshotAction(1);
    }

    public function testSetOrderByParam()
    {
        $paramFetcher = $this->getMockBuilder('FOS\RestBundle\Request\ParamFetcherInterface')
            ->setMethods(['addParam', 'setController', 'get', 'all'])
            ->getMock();
        $paramFetcher->expects($this->any())->method('addParam')->will($this->returnValue($paramFetcher));

        $snapshotManager = $this->getMockBuilder('Sonata\PageBundle\Model\SnapshotManagerInterface')->getMock();

        $result = $this->createSnapshotController(null, $snapshotManager)->setOrderByParam($paramFetcher);

        $this->assertEquals($paramFetcher, $result);
    }

    /**
     * @param $snapshot
     * @param $snapshotManager
     *
     * @return SnapshotController
     */
    public function createSnapshotController($snapshot = null, $snapshotManager = null)
    {
        if (null === $snapshotManager) {
            $snapshotManager = $this->getMockBuilder('Sonata\PageBundle\Model\SnapshotManagerInterface')->getMock();
        }
        if (null !== $snapshot) {
            $snapshotManager->expects($this->once())->method('findOneBy')->will($this->returnValue($snapshot));
        }

        return new SnapshotController($snapshotManager);
    }
}