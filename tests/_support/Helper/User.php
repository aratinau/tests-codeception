<?php
namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Tests\ApiTester;

class User extends \Codeception\Module
{
    public function createAdminAndGetToken(ApiTester $I)
    {
        return $I->have(\App\Entity\User::class, ['roles' => ['ROLE_ADMIN']]);
    }

    public function helloUser(ApiTester $I)
    {
        return $I->have(\App\Entity\User::class);
    }
}
