<?php

class SendingMessageFunctionalCest
{
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

    public function sendMessageWithoutMessage(FunctionalTester $I)
    {
        $I->amOnPage('/admin/message/messageuser/create');
        $I->click(['css' => 'button[name=btn_create_and_list]']);
        $I->see(' An error has occurred during the creation of item ');
    }
}
