<?php


class MessageTemplateCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/login');
        $I->fillField('_username', 'root');
        $I->fillField('_password', 'root');
        $I->click(['css' => "button[type='submit']"]);
    }

    public function _after(AcceptanceTester $I)
    {

    }

    public function tryToTest(AcceptanceTester $I)
    {
        $subject = 'Hello!';
        $I->am('admin');
        $I->wantTo('create message template');
        $I->lookForwardTo('see my template in templates list');
        $I->amOnPage('/admin/message/messagetemplate/create');
        $I->fillField('Subject', $subject);
        $I->fillField('Template', 'super template');
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->see('Item "Template "' . $subject . '"" has been successfully created.');
    }
}
