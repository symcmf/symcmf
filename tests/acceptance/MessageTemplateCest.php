<?php


class MessageTemplateCest
{
    public function _before(AcceptanceTester $I)
    {
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
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->fillField('Template', 'super template');
        $I->see('Item "Template "' . $subject . '"" has been successfully created.');
    }
}
