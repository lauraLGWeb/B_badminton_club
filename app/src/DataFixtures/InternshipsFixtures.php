<?php

namespace App\DataFixtures;

use App\Entity\Internships;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InternshipsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $internships = [
            [
                'Stage Découverte Badminton',
                '2026-03-02 14:00:00',
                'Rabelais',
                '15.00',
                16,
                0
            ],
            [
                'Stage Progression Simple',
                '2026-03-02 14:00:00',
                'Rabelais',
                '20.00',
                3,
                0
            ],
            [
                'Stage Double & Placement',
                '2026-03-02 14:00:00',
                'Rabelais',
                '18.00',
                16,
                0
            ],
            [
                'Stage Jeunes Compétition',
                '2026-03-02 14:00:00',
                'Rabelais',
                '12.00',
                20,
                0
            ],
            [
                'Stage Perfectionnement Adultes',
                '2026-03-02 14:00:00',
                'Rabelais',
                '22.00',
                14,
                0
            ],
        ];

        foreach ($internships as [
            $title,
            $dateTime,
            $gymnase,
            $price,
            $maxPlayers,
            $alreadyBooked
        ]) {
            $internship = new Internships();
            $internship->setInternshipTitle($title);
            $internship->setDateTime(new \DateTime($dateTime));
            $internship->setGymnase($gymnase);
            $internship->setPrice($price);
            $internship->setMaxPlayersNbr($maxPlayers);
            $internship->setAlreadyBooked($alreadyBooked);

            $manager->persist($internship);
        }

        $manager->flush();
    }
}
