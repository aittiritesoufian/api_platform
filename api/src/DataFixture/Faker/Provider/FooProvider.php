<?php

#api/src/DataFixtures/Faker/Provider/FooProvider.php
namespace App\DataFixtures\Faker\Provider;

class FooProvider
{
    public static function foo($str)
    {
        return 'foo'.$str;
    }
}