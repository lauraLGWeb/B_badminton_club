<?php

namespace App\DataFixtures\MongoDB;

use App\Document\Actualities;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActualitesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actualitesData = [
            [
                'title' => 'Tournoi régional',
                'description' => 'Tournoi régional ouvert à tous les niveaux.',
                'picture' => 'tournoi.jpg',
                'eventOn' => new \DateTime('2026-02-15'),
            ],
            [
                'title' => 'Stage jeunes',
                'description' => 'Stage de perfectionnement pour les jeunes du club.',
                'picture' => 'stage-jeunes.jpg',
                'eventOn' => new \DateTime('2026-03-01'),
            ],
            [
                'title' => 'Assemblée générale',
                'description' => 'Assemblée générale annuelle du club.',
                'picture' => 'ag.jpg',
                'eventOn' => new \DateTime('2026-01-30'),
            ],
            [
                'title' => 'Interclubs',
                'description' => 'Rencontre interclubs à domicile.',
                'picture' => 'interclubs.jpg',
                'eventOn' => new \DateTime('2026-02-05'),
            ],
            [
                'title' => 'Soirée conviviale',
                'description' => 'Soirée détente et échanges entre adhérents.',
                'picture' => 'soiree.jpg',
                'eventOn' => new \DateTime('2026-02-22'),
            ],
            [
                'title' => 'Reprise des entraînements',
                'description' => 'Reprise officielle des entraînements après les vacances.',
                'picture' => 'reprise.jpg',
                'eventOn' => new \DateTime('2026-01-20'),
            ],
        ];

        foreach ($actualitesData as $data) {
            $actualite = new Actualities();
            $actualite
                ->setTitle($data['title'])
                ->setDescription($data['description'])
                ->setPicture($data['picture'])
                ->setEventOn($data['eventOn']);

            $manager->persist($actualite);
        }

        $manager->flush();
    }
}
