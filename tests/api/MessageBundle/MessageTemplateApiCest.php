<?php

class MessageTemplateApiCest
{
    public function _before()
    {

    }

    public function _after()
    {

    }

    public function createTemplate(ApiTester $I)
    {
        $faker = \Faker\Factory::create();
        $subject = $faker->word;
        $template = $faker->word;
        $I->sendPOST('/templates', [
            'subject' => $subject,
            'template' => $template
        ]);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'subject' => $subject,
            'template' => $template
        ]);
        $I->seeResponseCodeIs(200);
    }

    public function createTemplateWithoutSubject(ApiTester $I)
    {
        $I->sendPOST('/templates', [
            'template' => 'super template'
        ]);
        $I->seeResponseIsJson();
        $I->seeResponseContains('This value should not be null');
        $I->seeResponseCodeIs(400);
    }

    public function createTemplateWithShortSubject(ApiTester $I)
    {
        $I->sendPOST('/templates', [
            'subject' => 's',
            'template' => 'super template'
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Subject must be at least 2 characters long');
    }

    public function createTemplateWithoutTemplate(ApiTester $I)
    {
        $I->sendPOST('/templates', [
            'subject' => 'super subject',
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContains('This value should not be null');
    }
}
