<?php

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
    public function tryToCreateUser(Anonymous $I)
    {

    }


}
