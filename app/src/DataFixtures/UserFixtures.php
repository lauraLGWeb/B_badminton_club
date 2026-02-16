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

        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName())
                 ->setLastName($faker->lastName())
                 ->setPhoneNbr($faker->numerify('06########'))
                 ->setEmail($faker->unique()->safeEmail());

            // Generate 7-digit license number (nullable, so 50% chance of having one)
            if ($i % 2 === 0) {
                $lienceNbr = $faker->numerify('#######');
                $user->setLienceNbr($lienceNbr);
            }

            // Mot de passe par défaut
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'Motdepasse123');
            $user->setPassword($hashedPassword);

            // Assign ONE role per user
            // 5 admins, 3 trainers, 12 regular members
            if ($i < 5) {
                // First 5 users: ADMIN
                $user->setRoles(['ROLE_ADMIN']);
            } elseif ($i < 8) {
                // Next 3 users: TRAINER
                $user->setRoles(['ROLE_ENTRAINEUR']);
            } else {
                // Remaining 12 users: MEMBER (default role)
                $user->setRoles(['ROLE_MEMBRE']);
            }


            $manager->persist($user);
        }

        $manager->flush();
    }
}