<?php
namespace PageBundle;
use \FunctionalTester;

class SiteFunctionalCest
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

    public function testCreateSite(FunctionalTester $I)
    {
        $faker = \Faker\Factory::create();

        $name = $faker->word;
        $host = 'localhost';

        $I->am('admin');
        $I->wantTo('create site');
        $I->lookForwardTo('see new site in list');

        $I->amOnPage('/admin/sonata/page/site/create');
        $I->fillField('Name', $name);
        $I->fillField('Host', $host);
        $I->fillField('Relative Path', $faker->url);
        $I->fillField('Enabled From', date("M j, Y, g:i:s a"));
        $I->click(['css' => 'button[name=btn_create_and_edit]']);
        $I->see('Item "' . $name . '" has been successfully created.');
    }

    public function testCreateSiteWithoutName(FunctionalTester $I)
    {
        $faker = \Faker\Factory::create();

        $host = 'localhost';

        $I->am('admin');
        $I->wantTo('create site without name');
        $I->lookForwardTo('see error');
        $I->amOnPage('/admin/sonata/page/site/create');

        $I->fillField('Name', '');
        $I->fillField('Host', $host);
        $I->fillField('Relative Path', $faker->url);
        $I->fillField('Enabled From', date("M j, Y, g:i:s a"));
        $I->click(['css' => 'button[name=btn_create_and_edit]']);

        $I->see('An error has occurred during the creation of item');
        $I->see('This value should not be null');
    }

    public function testCreateSiteWithoutHost(FunctionalTester $I)
    {
        $faker = \Faker\Factory::create();

        $I->am('admin');
        $I->wantTo('create site without host');
        $I->lookForwardTo('see error');
        $I->amOnPage('/admin/sonata/page/site/create');

        $name = $faker->word;

        $I->fillField('Name', $name);
        $I->fillField('Host', '');
        $I->fillField('Relative Path', $faker->url);
        $I->fillField('Enabled From', date('M j, Y, g:i:s a'));
        $I->click(['css' => 'button[name=btn_create_and_edit]']);

        $I->see('An error has occurred during the creation of item');
        $I->see('This value should not be null');
    }

    public function testCreateSiteWitInvalidTime(FunctionalTester $I)
    {
        $faker = \Faker\Factory::create();

        $I->am('admin');
        $I->wantTo('create site with invalid time in field enabled from');
        $I->lookForwardTo('see error');
        $I->amOnPage('/admin/sonata/page/site/create');

        $name = $faker->word;

        $I->fillField('Name', $name);
        $I->fillField('Host', 'localhost');
        $I->fillField('Relative Path', $faker->url);
        $I->fillField('Enabled From', date("Y, g:i:s a"));
        $I->click(['css' => 'button[name=btn_create_and_edit]']);

        $I->see('An error has occurred during the creation of item');
        $I->see('This value is not valid');
    }

}
