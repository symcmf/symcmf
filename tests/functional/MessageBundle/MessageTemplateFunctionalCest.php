<?php


class MessageTemplateFunctionalCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/admin/login');
        $I->fillField('_username', 'root');
        $I->fillField('_password', 'root');
        $I->click(['css' => "button[type='submit']"]);
    }

    public function _after(FunctionalTester $I)
    {

    }

    public function createTemplate(FunctionalTester $I)
    {
        $faker = \Faker\Factory::create();
        $subject = $faker->word;
        $I->am('admin');
        $I->wantTo('create message template');
        $I->lookForwardTo('see my template in templates list');
        $I->amOnPage('/admin/message/messagetemplate/create');
        $I->fillField('Subject', $subject);
        $I->fillField('Template', 'super template');
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->see('Item "Template "' . $subject . '"" has been successfully created.');
    }

    public function createTemplateWithoutSubject(FunctionalTester $I)
    {
        $I->amOnPage('/admin/message/messagetemplate/create');
        $I->fillField('Template', 'super template');
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->see('This value should not be null');
    }

    public function createTemplateWithShortSubject(FunctionalTester $I)
    {
        $I->amOnPage('/admin/message/messagetemplate/create');
        $I->fillField('Subject', 'q');
        $I->fillField('Template', 'super template');
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->see('Subject must be at least 2 characters long');
    }

    public function createTemplateWithExistingSubject(FunctionalTester $I)
    {
        $this->createSameTemplate($I);
        $this->createSameTemplate($I);
        $I->see('Sorry, ');
    }

    public function createSameTemplate($I)
    {
        $I->amOnPage('/admin/message/messagetemplate/create');
        $I->fillField('Subject', 'fail');
        $I->fillField('Template', 'super template');
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
    }

    public function createTemplateWithoutTemplate(FunctionalTester $I)
    {
        $faker = \Faker\Factory::create();
        $subject = $faker->word;
        $I->amOnPage('/admin/message/messagetemplate/create');
        $I->fillField('Subject', $subject);
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->see('This value should not be null');
    }
}
