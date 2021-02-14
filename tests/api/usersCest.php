<?php namespace App\Tests;
use App\Entity\User;
use App\Tests\ApiTester;
use App\Tests\Helper\Api;

class usersCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToCreateUserByAPI(ApiTester $I)
    {
        $I->am('a anonymous user');
        $I->wantTo('create a user by API');
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPOST('/api/users', [
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

    public function tryToGetUser(ApiTester $I)
    {
        $user = $I->helloUser($I);

        $I->seeInRepository(User::class, ['email' => $user->getEmail()]);
    }

    public function tryToLogIn(ApiTester $I)
    {
        $user = $I->helloUser($I);

        $I->seeInRepository(User::class, ['email' => $user->getEmail()]);

        $I->sendPOST('/fr/api/login', [
            'username' => $user->getUsername(),
            'password' => '1234',
        ]);
    }
}
