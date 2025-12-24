<?php
// creation of 50 user : 10 admin and 5 coaches
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
     private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName())
                 ->setLastName($faker->lastName())
                 ->setEmail($faker->unique()->safeEmail());

            // Numéro de licence aléatoire entre 7 et 10 chiffres
            $lienceNbr = '';
            for ($j = 0; $j < 7; $j++) {
                $lienceNbr .= rand(0, 9);
            }
            $user->setLienceNbr((int)$lienceNbr);

            // Mot de passe par défaut
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'motdepasse123');
            $user->setPassword($hashedPassword);

            // roles
            $roles = ['ROLE_MEMBRE'];
            if ($i < 10) {
                // 10admin 
                $roles[] = 'ROLE_ADMIN';
            } elseif ($i < 15) {
                // 5 coaches in exemple
                $roles[] = 'ROLE_ENTRAINEUR';
            }
            $user->setRoles($roles);

            $manager->persist($user);
        }

        $manager->flush();
    }
}