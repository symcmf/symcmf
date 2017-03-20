<?php

class SendingMessageApiCest
{
    /**
     * @var integer
     */
    private $templateId;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @param ApiTester $I
     *
     * @return integer
     */
    private function getLastIterator(ApiTester $I)
    {
        $total = $I->grabDataFromResponseByJsonPath('$.total')[0];
        $perPage = $I->grabDataFromResponseByJsonPath('$.per_page')[0];

        // need to get last iterator on page
        $total = $total > $perPage ? $perPage : $total;

        return $total - 1;
    }

    public function _before(ApiTester $I)
    {
        $faker = \Faker\Factory::create();
        $subject = $faker->word;

        // Add new template
        $I->sendPOST('/templates', [
            'subject' => $subject,
            'template' => 'super template'
        ]);
        $I->seeResponseCodeIs(200);

        // get last added template
        $I->sendGET('/templates');
        $I->seeResponseCodeIs(200);
        $iterator = $this->getLastIterator($I);
        $result = $I->grabDataFromResponseByJsonPath('$..entries[' . $iterator . '].id');
        $this->templateId = $result[0];

        // add new user
        $username = $faker->name;
        $email = $faker->email;
        $I->sendPOST('/user/users', [
            'username' => $username,
            'email' => $email,
            'plainPassword' => $faker->password
        ]);
        $I->seeResponseCodeIs(200);

        // get last added user
        $I->sendGET('/user/users');
        $I->seeResponseCodeIs(200);
        $iterator = $this->getLastIterator($I);
        $result = $I->grabDataFromResponseByJsonPath('$..entries[' . $iterator . '].id');
        $this->userId = $result[0];
    }

    public function _after()
    {

    }

    public function sendMessage(ApiTester $I)
    {
        $I->sendPOST('/messages/' . $this->templateId . '/templates/' . $this->userId . '/users');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
