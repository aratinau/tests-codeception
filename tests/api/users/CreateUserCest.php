<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\users;

use App\Entity\User;
use App\Tests\ApiTester;
use App\Tests\Step\Api\Anonymous;

class CreateUserCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     *
     * @group user
     * @group user_create
     */
    public function tryToCreateUserByAPI(Anonymous $I)
    {
        $I->am('a anonymous user');
        $I->wantTo('create a user');
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPOST('/users', [
            'fullName' => 'fullname',
            'username' => 'username',
            'email' => 'test-create@test.tld',
            'password' => 'pass123AZE@',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'email' => 'test-create@test.tld',
        ]);

        $I->seeInRepository(User::class, ['email' => 'test-create@test.tld']);
    }
}
