<?php


use MessageBundle\Entity\MessageTemplate;
use MessageBundle\Entity\MessageUser;

class MessageUserEntityTest extends \Codeception\Test\Unit
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

    public function testGetMessage()
    {
        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->setMethods([
                'setMessage',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $msgTemplate = new MessageTemplate();

        $this->assertEquals(null, $manager->getMessage());

        $managerReflection = new \ReflectionClass($manager);
        $templates = $managerReflection->getProperty('message');
        $templates->setAccessible(true);
        $templates->setValue($manager, $msgTemplate);

        $this->assertEquals($msgTemplate, $manager->getMessage());

    }

    public function testSetMessage()
    {
        $manager = new MessageUser();
        $msgTemplate = new MessageTemplate();

        $this->assertEquals(null, $manager->getMessage());

        $manager->setMessage($msgTemplate);

        $this->assertEquals($msgTemplate, $manager->getMessage());
    }

    public function testGetUser()
    {
        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->setMethods([
                'setMessage',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $user = $this->getMockBuilder('Application\Sonata\UserBundle\Entity\User')
            ->getMock();

        $this->assertEquals(null, $manager->getUser());

        $managerReflection = new \ReflectionClass($manager);
        $templates = $managerReflection->getProperty('user');
        $templates->setAccessible(true);
        $templates->setValue($manager, $user);

        $this->assertEquals($user, $manager->getUser());

    }

    public function testSetUser()
    {
        $manager = new MessageUser();

        $user = $this->getMockBuilder('Application\Sonata\UserBundle\Entity\User')
            ->getMock();

        $this->assertEquals(null, $manager->getUser());

        $manager->setUser($user);

        $this->assertEquals($user, $manager->getUser());
    }

    public function testToStringWithMessage()
    {
        $manager = new MessageUser();
        $message = new MessageTemplate();

        $message->setSubject('test subject');

        $manager->setMessage($message);

        $string = (string) $manager;

        $this->assertEquals('Message "test subject"', $string, 'Should return a string representation');
    }

    public function testToStringWithoutMessage()
    {
        $manager = new MessageUser();

        $string = (string) $manager;

        $this->assertEquals('Message "<name>"', $string, 'Should return a string representation');
    }


    public function testGetCreated()
    {
        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->setMethods([
                'setCreated',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $today = new \DateTime();

        $managerReflection = new \ReflectionClass($manager);
        $templates = $managerReflection->getProperty('created');
        $templates->setAccessible(true);
        $templates->setValue($manager, $today);

        $this->assertEquals($today, $manager->getCreated());

    }


    public function testSetCreated()
    {
        $manager = new MessageUser();
        $today = new \DateTime();

        $this->assertEquals(null, $manager->getCreated());

        $manager->setCreated($today);

        $this->assertEquals($today, $manager->getCreated());
    }
}
