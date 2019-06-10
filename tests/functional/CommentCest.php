<?php

namespace App\Tests;

use App\Entity\Comment;
use Codeception\Util\HttpCode;

class CommentCest
{
    public function createComment(FunctionalTester $I)
    {
        $I->amOnLocalizedPage('/login');
        $I->submitForm('#main form', ['_username' => 'john_user', '_password' => 'kitten']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentRouteIs('blog_index');
        $I->click('article.post > h2 a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentRouteIs('blog_post');
        $I->dontSee('Hi, Symfony!');
        $I->fillField('comment[content]', 'Hi, Symfony!');
        $I->submitForm('#post-add-comment > form', []);
        $I->seeCurrentRouteIs('blog_post');
        $I->see('Hi, Symfony!');
        // This particular assertion is a bit of overkill, but it also serves as a testcase
        // of `seeInRepository` method with complex associations. Here is how this assertion
        // translates to English:
        //
        //   * I see a comment entity with content equal to 'Hi, Symfony!'
        //   * and 'author' association points to a user entity with username equal to 'john_user'
        //   ** note: john_user is one who created the comment, as it is used in login
        //      procedure above
        //   * and 'post' association points to a post entity which...
        //   * ...has an associated comment entity which...
        //   * ...has same content and author with same username.
        $I->seeInRepository(Comment::class, [
            'content' => 'Hi, Symfony!',
            'author' => [
                'username' => 'john_user',
            ],
            'post' => [
                'comments' => [
                    'content' => 'Hi, Symfony!',
                    'author' => [
                        'username' => 'john_user'
                    ]
                ]
            ]
        ]);
    }

}
