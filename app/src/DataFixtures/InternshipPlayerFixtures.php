<?php

namespace App\DataFixtures;

use App\Entity\InternshipPlayer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InternshipPlayerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $players = [
            ['Dupont', 'Lucas', 'lucas.dupont@test.fr', '0600000001', 'NC'],
            ['Martin', 'Emma', 'emma.martin@test.fr', '0600000002', 'NC'],
            ['Durand', 'Leo', 'leo.durand@test.fr', '0600000003', 'NC'],
            ['Bernard', 'Chloe', 'chloe.bernard@test.fr', '0600000004', 'P12'],
            ['Petit', 'Hugo', 'hugo.petit@test.fr', '0600000005', 'P11'],
            ['Robert', 'Ines', 'ines.robert@test.fr', '0600000006', 'P10'],
            ['Richard', 'Tom', 'tom.richard@test.fr', '0600000007', 'P10'],
            ['Moreau', 'Sarah', 'sarah.moreau@test.fr', '0600000008', 'D9'],
            ['Simon', 'Noah', 'noah.simon@test.fr', '0600000009', 'D8'],
            ['Laurent', 'Lina', 'lina.laurent@test.fr', '0600000010', 'D8'],
            ['Michel', 'Ethan', 'ethan.michel@test.fr', '0600000011', 'D7'],
            ['Garcia', 'Manon', 'manon.garcia@test.fr', '0600000012', 'R6'],
            ['Fournier', 'Alex', 'alex.fournier@test.fr', '0600000013', 'R6'],
            ['Girard', 'Julie', 'julie.girard@test.fr', '0600000014', 'R6'],
            ['Andre', 'Paul', 'paul.andre@test.fr', '0600000015', 'R6'],
        ];

        foreach ($players as [$lastName, $firstName, $email, $phone, $simpleRank]) {
            $player = new InternshipPlayer();
            $player->setLastName($lastName);
            $player->setFirstName($firstName);
            $player->setEmail($email);
            $player->setPhoneNumber($phone);
            $player->setSimpleRank($simpleRank);

            // can ajust if neede but for fixture i put the same rank 
            $player->setDoubleRank($simpleRank);
            $player->setMixteRank($simpleRank);

            $manager->persist($player);
        }

        $manager->flush();
    }
}
