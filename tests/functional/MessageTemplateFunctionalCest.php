<?php


class MessageTemplateFunctionalCest
{
    // not working
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/admin/login');
        $I->fillField('_username', 'adminuser');
        $I->fillField('_password', '123456');
        $I->click(['css' => "button[type='submit']"]);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryToTest(FunctionalTester $I)
    {
        $subject = 'Hello!';
        $I->am('admin');
        $I->wantTo('create message template');
        $I->lookForwardTo('see my template in templates list');
        $I->amOnPage('/admin/message/messagetemplate/create');
        $I->fillField('Subject', $subject);
        $I->click('Create');
        $I->fillField('Template', 'super template');
        $I->see('Item "Template "' . $subject . '"" has been successfully created.');
    }
}
