<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ProductFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // T-shirt
        $tshirt = new Product();
        $tshirt->setTitle('T-shirt basique')
               ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
               ->setPrice(40)
               ->setPicture('pictures/tshirt.jpg')
               ->setHasSize('');
        $manager->persist($tshirt);

        // Boîte de volants
        $shuttlecocks = new Product();
        $shuttlecocks->setTitle('Boîte de volants')
                      ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
                      ->setPrice(30)
                      ->setPicture('pictures/volantsboite.jpg');
        $manager->persist($shuttlecocks);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['products'];
    }
}
