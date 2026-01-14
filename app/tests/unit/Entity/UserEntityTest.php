<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Cart;

class UserEntityTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    /**
     * TEST 1 : Email getter/setter
     */
    public function testEmailGetterSetter(): void
    {
        $email = 'lvalentin@example.org';
        $this->user->setEmail($email);
        
        $this->assertEquals($email, $this->user->getEmail());
    }

    /**
     * TEST 2 : get the User 
     */
    public function testGetUser(): void
    {
        $email = 'lvalentin@example.org';
        $this->user->setEmail($email);
        
        $this->assertEquals($email, $this->user->getUserIdentifier());
    }

    /**
     * TEST 3 : ROLE_MEMBRE default added on user
     */
    public function testRoleMembreByDefault(): void
    {
        $roles = $this->user->getRoles();
        
        $this->assertContains('ROLE_MEMBRE', $roles);
    }

 

    /**
     * TEST 4 : FirstName getter/setter
     */
    public function testFirstNameGetterSetter(): void
    {
        $firstName = 'Marcelle';
        $this->user->setFirstName($firstName);
        
        $this->assertEquals($firstName, $this->user->getFirstName());
    }

    /**
     * TEST 5 : LastName getter/setter
     */
    public function testLastNameGetterSetter(): void
    {
        $lastName = 'Hamon';
        $this->user->setLastName($lastName);
        
        $this->assertEquals($lastName, $this->user->getLastName());
    }

    /**
     * TEST 6 : LicenseNumber getter/setter
     */
    public function testLicenseNumberGetterSetter(): void
    {
        $license = 8915476;
        $this->user->setLienceNbr($license);
        
        $this->assertEquals($license, $this->user->getLienceNbr());
    }

    /**
     * TEST 7 : Password getter/setter
     */
    public function testPasswordGetterSetter(): void
    {
        $password = 'hashed_password';
        $this->user->setPassword($password);
        
        $this->assertEquals($password, $this->user->getPassword());
    }

    
}