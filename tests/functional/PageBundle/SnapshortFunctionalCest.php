<?php
namespace PageBundle;
use Application\Sonata\PageBundle\Entity\Site;
use \FunctionalTester;

class SnapshortFunctionalCest
{
    private $id;

    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/admin/login');
        $I->fillField('_username', 'root');
        $I->fillField('_password', 'root');
        $I->click(['css' => "button[type='submit']"]);

        $faker = \Faker\Factory::create();

        $name = $faker->word;
        $host = 'localhost';
        $relativePath = $faker->url;

        $I->amOnPage('/admin/sonata/page/site/create');

        $I->fillField('Name', $name);
        $I->fillField('Host', $host);
        $I->fillField('Relative Path', $relativePath);
        $I->fillField('Enabled From', date("M j, Y, g:i:s a"));

        $I->click(['css' => 'button[name=btn_create_and_list]']);
        $I->see('Item "' . $name . '" has been successfully created.');

        $this->id = $I->grabFromRepository(Site::class, 'id', [
            'name' => $name,
            'relativePath' => $relativePath,
            'host' => $host
        ]);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryToCreateSnapshots(FunctionalTester $I)
    {
        $I->am('admin');
        $I->wantTo('create snapshots to site');

        $I->amOnPage('/admin/sonata/page/site/' . $this->id . '/snapshots');
        $I->click(['css' => 'button[name=create]']);

        $I->see('Snapshots were successfully created.');
    }
}
