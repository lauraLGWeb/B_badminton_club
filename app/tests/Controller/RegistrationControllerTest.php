<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegistrationPageIsAccessible(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/membre/inscription');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Créer'); 
        $this->assertCount(1, $crawler->filter('form'));
    }




    public function testUserCanRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/membre/inscription');

        // Remplir le formulaire
        $form = $crawler->selectButton('Créer mon compte')->form([ 
            'registration_form[email]' => 'efeutest@example.com',
            'registration_form[lastName]' => 'Vallet',
            'registration_form[firstName]' => 'laura',
            'registration_form[plainPassword]' => 'Mappy123',
            'registration_form[lienceNbr]' => '9958978',
            'registration_form[agreeTerms]' => 1,
            
        ]);

        $client->submit($form);

        // redirection after validation
        $this->assertResponseRedirects();
        $client->followRedirect();

        

        // is the user created in database
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'laura@example.net']);

        $this->assertNotNull($user);
        $this->assertSame('Vallet', $user->getLastName());
        $this->assertSame('laura', $user->getFirstName());
        $this->assertContains('ROLE_MEMBRE', $user->getRoles());

        // is the password hashed 
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        $this->assertTrue($passwordHasher->isPasswordValid($user, 'Mappy123'));

        //  should connect the user
        $this->assertNotNull($client->getContainer()->get('security.token_storage')->getToken());
    }





    public function testRegistrationWithInvalidData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/membre/inscription');

        //  invalid user
        $form = $crawler->selectButton('Créer mon compte')->form([
            'registration_form[email]' => 'invalid-mail',
            'registration_form[lastName]' => 'Test',
            'registration_form[firstName]' => 'User',
            'registration_form[plainPassword]' => '123', 
            'registration_form[lienceNbr]' => '7050503',
            'registration_form[agreeTerms]' => 1,
        ]);

        $client->submit($form);

        // should stay on the page and show the errors
        $this->assertResponseStatusCodeSame(422);
        
    }

    public function testCannotRegisterWithExistingEmail(): void
    {
        $client = static::createClient();
        
        // Créer un utilisateur existant
        $userRepository = static::getContainer()->get(UserRepository::class);
        $existingUser = $userRepository->findOneBy(['email' => 'adelaide66@example.net']);

        $crawler = $client->request('GET', '/membre/inscription');

        $form = $crawler->selectButton('Créer mon compte')->form([
            'registration_form[email]' => $existingUser->getEmail(),
            'registration_form[lastName]' => 'Vallet',
            'registration_form[firstName]' => 'Margot',
            'registration_form[plainPassword]' => 'motdepasse123',
            'registration_form[lienceNbr]' => '9194197',
            'registration_form[agreeTerms]' => 1,
        ]);

        $client->submit($form);

        // shouldnt create because already existing email
        $this->assertResponseStatusCodeSame(422);
        
    }
}