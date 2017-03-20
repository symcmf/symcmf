<?php


use Application\Sonata\UserBundle\Entity\ApplicationBaseUser;

class ApplicationBaseUserEntityTest extends \Codeception\Test\Unit
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

    public function testPrePersist()
    {
        $user = new ApplicationBaseUser();

        $this->assertEquals(null, $user->getCreatedAt());
        $this->assertEquals(null, $user->getUpdatedAt());

        $user->prePersist();

        $this->assertInstanceOf(\DateTime::class, $user->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $user->getUpdatedAt());
    }

    /**
     * Hook on pre-update operations.
     */
    public function testPreUpdate()
    {
        $user = new ApplicationBaseUser();

        $user->prePersist();

        $prevCreate = $user->getCreatedAt();
        $prevUpdate = $user->getUpdatedAt();

        $user->preUpdate();

        $this->assertEquals($prevCreate, $user->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $user->getUpdatedAt());
    }

    // tests
    public function testGetGenderList()
    {
        $user = new ApplicationBaseUser();

        $result = [
            'u' => 'gender_unknown',
            'f' => 'gender_female',
            'm' => 'gender_male',
        ];

        $this->assertEquals($result, $user->getGenderList());
    }
}
