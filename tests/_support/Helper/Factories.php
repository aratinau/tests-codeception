<?php
namespace App\Tests\Helper;

use App\Entity\User;
use League\FactoryMuffin\Faker\Facade as Faker;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Factories extends \Codeception\Module
{
    public function _beforeSuite($settings = [])
    {
        $factory = $this->getModule('DataFactory');
        // let us get EntityManager from Doctrine
        $em = $this->getModule('Doctrine2')->_getEntityManager();

        $factory->_define(User::class, [
            'email' => Faker::email(),
            'fullName' => Faker::word(),
            'username' => Faker::password(),
            'password' => "1234",
        ]);
    }
}
