<?php

class SendingMessageApiCest
{
    private $templateId;

    private $userId;

    public function _before(ApiTester $I)
    {
        $faker = \Faker\Factory::create();
        $subject = $faker->word;
        $I->sendPOST('/templates', [
            'subject' => $subject,
            'template' => 'super template'
        ]);
        $I->seeResponseCodeIs(200);
        $this->templateId = $I->grabFromDatabase('message_template', 'id', [
            'subject' => $subject,
            'template' => 'super template'
        ]);
        $username = $faker->name;
        $email = $faker->email;
        $I->sendPOST('/user/users', [
            'username' => $username,
            'email' => $email,
            'plainPassword' =>$faker->password
        ]);
        $I->seeResponseCodeIs(200);
        $this->userId = $I->grabFromDatabase('fos_user_user', 'id', [
            'username' => $username,
            'email' => $email,
        ]);
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
