<?php


class UserEntityTest extends \Codeception\Test\Unit
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

    public function testAddMessageUser()
    {
        $msgUser = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->getMockBuilder('Application\Sonata\UserBundle\Entity\User')
            ->setMethods([
                'test',
            ])
            ->getMock();

        $this->assertEquals([], $manager->getMessageUser());

        $manager->addMessageUser($msgUser);

        $this->assertEquals([$msgUser], $manager->getMessageUser());
    }

    public function testRemoveMessageUser()
    {
        $msgUser = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->getMockBuilder('Application\Sonata\UserBundle\Entity\User')
            ->setMethods([
                'test',
            ])
            ->getMock();

        $manager->addMessageUser($msgUser);

        $this->assertEquals([$msgUser], $manager->getMessageUser());

        $manager->removeMessageUser($msgUser);

        $this->assertEquals([], $manager->getMessageUser());
    }
}