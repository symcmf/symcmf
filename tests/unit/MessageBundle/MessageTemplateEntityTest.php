<?php

class MessageTemplateEntityTest extends \Codeception\Test\Unit
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

    /**
     * @param $object
     * @param $name
     * @param $value
     */
    protected static function setVariable($object, $name, $value)
    {
        $class = new ReflectionClass($object);
        $variable = $class->getProperty($name);
        $variable->setAccessible(true);
        $variable->setValue($object, $value);
    }

    public function testSetSubject()
    {
        $msgTemplate = $this->getMockBuilder('MessageBundle\Entity\MessageTemplate')
            // we need to set at least one method, which does not need to exist!
            // otherwise all methods will be mocked and could not be used!
            ->setMethods([
                'needToMock',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertEquals('', $msgTemplate->getSubject());

        $msgTemplate->setSubject('test subject');

        $this->assertEquals('test subject', $msgTemplate->getSubject());
    }

    public function testGetSubject()
    {
        $msgTemplate = $this->getMockBuilder('MessageBundle\Entity\MessageTemplate')
            ->setMethods([
                'setSubject',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        self::setVariable($msgTemplate, 'subject', 'test subject');

        $this->assertEquals('test subject', $msgTemplate->getSubject());

    }

    public function testSetTemplate()
    {
        $msgTemplate = $this->getMockBuilder('MessageBundle\Entity\MessageTemplate')
            // we need to set at least one method, which does not need to exist!
            // otherwise all methods will be mocked and could not be used!
            ->setMethods([
                'needToMock',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertEquals('', $msgTemplate->getTemplate());

        $msgTemplate->setTemplate('test');

        $this->assertEquals('test', $msgTemplate->getTemplate());
    }

    public function testGetTemplate()
    {
        $msgTemplate = $this->getMockBuilder('MessageBundle\Entity\MessageTemplate')
            ->setMethods([
                'setTemplate',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        self::setVariable($msgTemplate, 'template', 'test test test test test test');

//        $managerReflection = new \ReflectionClass($msgTemplate);
//        $templates = $managerReflection->getProperty('template');
//        $templates->setAccessible(true);
//        $templates->setValue($msgTemplate, 'test test test test test test');

        $this->assertEquals('test test test test test test', $msgTemplate->getTemplate());

    }

    public function testAddMessageUser()
    {
        $msgUser = $this->getMockBuilder('MessageBundle\Entity\MessageUser')
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplate')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMock',
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

        $manager = $this->getMockBuilder('MessageBundle\Entity\MessageTemplate')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMock',
            ])
            ->getMock();

        $manager->addMessageUser($msgUser);

        $this->assertEquals([$msgUser], $manager->getMessageUser());

        $manager->removeMessageUser($msgUser);

        $this->assertEquals([], $manager->getMessageUser());
    }

}
