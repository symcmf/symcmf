<?php
namespace NewsBundle;

use \FunctionalTester;

class PostFunctionalCest
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

//    public function tryToCreatePost(FunctionalTester $I)
//    {
//        $I->am('admin');
//        $I->wantTo('create new post');
//        $I->amOnPage('/admin/sonata/news/post/create');
//
//        $path = $I->grabAttributeFrom('form[role="form"]', 'action');
//
//        $uniqId = substr(strrchr($path, '='), 1);
//        var_dump($uniqId);
//
////        $url = '/admin/core/get-short-object-description?objectId=1 ' .
////        '&uniqid=' . $uniqId . '&code=sonata.user.admin.user';
////        $I->sendAjaxGetRequest($url);
//
//        $faker = \Faker\Factory::create();
//
//        $I->fillField('Author', 'root@domain.ru');
//        $I->fillField('Title', $faker->title);
//        $I->fillField('Abstract', $faker->text(50));
//        $I->fillField('textarea[id*="_content_rawContent"]', $faker->text);
//
//        $I->selectOption('input[id*="_commentsDefaultStatus_0"]', 2);
//
//        $I->click(['css' => 'button[name=btn_create_and_edit]']);
//
//
//        $I->dontSee('root@domain.ru');
//
//    }

    public function tryToCreatePostWithoutAuthor(FunctionalTester $I)
    {
        $I->am('admin');
        $I->wantTo('create new post');
        $I->amOnPage('/admin/sonata/news/post/create');

        $faker = \Faker\Factory::create();
        $I->fillField('Title', $faker->title);
        $I->fillField('Abstract', $faker->text(50));
        $I->fillField('textarea[id*="_content_rawContent"]', $faker->text);

        $I->selectOption('input[id*="_commentsDefaultStatus_0"]', 2);

        $I->click(['css' => 'button[name=btn_create_and_edit]']);

        $I->see('An error has occurred during the creation of item');
        $I->see('This value should not be null');
    }
}
