<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        //admin

        $admin = new User();
        $admin->setEmail('admin@club.fr');
        $admin->setFirstName('Admin');
        $admin->setLastName('Principal');
        $admin->setLienceNbr(100000);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'password')
        );
        $manager->persist($admin);

        //coach

        $coach = new User();
        $coach->setEmail('coach@club.fr');
        $coach->setFirstName('Jean');
        $coach->setLastName('Coach');
        $coach->setLienceNbr(200000);
        $coach->setRoles(['ROLE_ENTRAINEUR']);

        $coach->setPassword(
            $this->passwordHasher->hashPassword($coach, 'password')
        );

        $manager->persist($coach);

        // Members
         
            $member = new User();
            $member->setEmail("laura@club.fr");
            $member->setFirstName("laura");
            $member->setLastName('lgl');
            $member->setLienceNbr(300000);

            // 👇 rôle par défaut
            $member->setRoles(['ROLE_MEMBRE']);

            $member->setPassword(
                $this->passwordHasher->hashPassword($member, 'password')
            );

            $manager->persist($member);

        $manager->flush();
    }
}
