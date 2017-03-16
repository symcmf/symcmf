<?php


use MessageBundle\Entity\MessageTemplate;

class MessageServiceTest extends \Codeception\Test\Unit
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
     * @param $name - name of method
     * @param $object - type of class
     *
     * @return ReflectionMethod
     */
    protected static function getMethod($name, $object)
    {
        $class = new ReflectionClass($object);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
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

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getUser()
    {
        $user = $this->getMockBuilder('Application\Sonata\UserBundle\Entity\User')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMockSomething',
            ])
            ->getMock();

        $user->setUsername('admin');
        $user->setEmail('admin@mail.com');

        return $user;
    }

    /**
     * @param null|string $template
     *
     * @return MessageTemplate
     */
    private function getMessage($template = null)
    {
        $message = new MessageTemplate();

        if (!$template) {
            $template = 'test1 {{username}} test2 {{email}}';
        }
        $message->setTemplate($template);

        return $message;
    }


    public function testGetAllowVariables()
    {
        $service = $this->getMockBuilder('MessageBundle\Services\MessageService')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMockSomething',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $result = [
            'username',
            'email',
            'firstname',
            'lastname',
        ];

        $this->assertEquals($result, $service->getAllowVariables());
    }

    /**
     * @dataProvider variablesCanReplaced
     */
    public function testCanReplaced($variable, $expected)
    {
        $service = $this->getMockBuilder('MessageBundle\Services\MessageService')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMockSomething',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        // get private|protected method
        $method = self::getMethod('canReplaced', $service);

        $this->assertEquals($expected, $method->invokeArgs($service, [$variable]));

    }

    /**
     * Data provider for method testCanReplaced
     *
     * @return array
     */
    public function variablesCanReplaced()
    {
        return [
            ['username', true],
            ['email', true],
            ['firstname', true],
            ['lastname', true],
            ['password', false],
        ];
    }

    /**
     * @dataProvider variablesGetMessageWithCorrectVariables
     */
    public function testGetMessage($template, $expected)
    {
        $service = $this->getMockBuilder('MessageBundle\Services\MessageService')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMockSomething',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $user = $this->getUser();
        $message = $this->getMessage($template);

        $method = self::getMethod('getMessage', $service);

        $this->assertEquals($expected, $method->invokeArgs($service, [$message, $user]));
    }

    /**
     * @return array
     */
    public function variablesGetMessageWithCorrectVariables()
    {
        return [
            ['test1 {{username}} test2 {{email}}', 'test1 admin test2 admin@mail.com'],
            ['test1 {{ username }} test2 {{ email }}', 'test1 admin test2 admin@mail.com'],
            ['test1 {{password}} test2 {{username}}', 'test1 {{password}} test2 admin'],
            ['test1 {{ password }} bad bad test2 {{username}}', 'test1 {{ password }} bad bad test2 admin'],
        ];
    }

    public function testSendMessage()
    {
        $service = $this->getMockBuilder('MessageBundle\Services\MessageService')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMockSomething',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $messageService = $this->getMockBuilder('MessageBundle\Services\Mailers\MailerService')
            ->setMethods([
                // we need to set at least one method, which does not need to exist!
                // otherwise all methods will be mocked and could not be used!
                'needToMockSomething',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $mailer = $this->getMockBuilder('Swift_Mailer')
            ->disableOriginalConstructor()
            ->getMock();

        $mailer->expects($this->any())->method('send')->willReturn(true);

        self::setVariable($messageService, 'mailer', $mailer);
        self::setVariable($service, 'mailerService', $messageService);

        $user = $this->getUser();
        $message = $this->getMessage();

        $this->assertTrue($service->sendMessage($message, $user));
    }
}
