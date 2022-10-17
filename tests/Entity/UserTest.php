<?php

namespace Test\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testNotValidEmail()
    {
        $this->expectException(\RuntimeException::class);
        
        $user = new User(1, 'Nicolas', 'VINCENT', 'email&notvalid.stz');
    }
}