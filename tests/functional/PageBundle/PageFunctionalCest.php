<?php
namespace PageBundle;
use \FunctionalTester;

class PageFunctionalCest
{
    private $duplicateName;

    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/admin/login');
        $I->fillField('_username', 'root');
        $I->fillField('_password', 'root');
        $I->click(['css' => "button[type='submit']"]);

        $faker = \Faker\Factory::create();
        $this->duplicateName = $faker->word;

    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryToCreatePage(FunctionalTester $I)
    {
        $I->am('admin');
        $I->wantTo('create new page');

        $I->amOnPage('/admin/sonata/page/page/create');

        $I->fillField('Name', $this->duplicateName);
        $I->selectOption('select[id*="_site"]', 'SCMF');
        $I->selectOption('select[id*="_parent"]', 'Homepage');

        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->see('Item "' . $this->duplicateName . '" has been successfully created.');
    }

    public function tryToCreatePageWithoutName(FunctionalTester $I)
    {
        $I->am('admin');
        $I->wantTo('create new page without name');

        $I->amOnPage('/admin/sonata/page/page/create');

        $I->fillField('Name', '');
        $I->selectOption('select[id*="_site"]', 'SCMF');
        $I->selectOption('select[id*="_parent"]', 'Homepage');

        $I->click(['css' => 'button[name=btn_create_and_edit]']);

        $I->see('An error has occurred during the creation of item');
        $I->see('This value should not be null');
    }

    public function tryToCreatePageWithDuplicateName(FunctionalTester $I)
    {
        $I->am('admin');
        $I->wantTo('create new page with duplicate name');

        $this->tryToCreatePage($I);

        $I->amOnPage('/admin/sonata/page/page/create');

        $I->fillField('Name', $this->duplicateName);
        $I->selectOption('select[id*="_site"]', 'SCMF');
        $I->selectOption('select[id*="_parent"]', 'Homepage');

        $I->click(['css' => 'button[name=btn_create_and_edit]']);

        $I->see('An error has occurred during the creation of item');
        $I->see('The URL \'/' . $this->duplicateName . '\' is already associated with another page.');
    }

    public function tryToCreatePageWithoutParent(FunctionalTester $I)
    {
        $I->am('admin');
        $I->wantTo('create new page without parent page');

        $faker = \Faker\Factory::create();
        $name = $faker->word;

        $I->amOnPage('/admin/sonata/page/page/create');
        $I->fillField('Name', $name);
        $I->selectOption('select[id*="_site"]', 'SCMF');

        $I->click(['css' => 'button[name=btn_create_and_edit]']);

        $I->see('An error has occurred during the creation of item');
        $I->see('The root URL \'/\' is already associated with another page of this site, please select a parent.');
    }
}
