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
               ->setSize('') // size will be chosen by the purchaser later
               ->setPicture('tshirt.jpg')
               ->setGender('')
               ->setHasSize('');
        $manager->persist($tshirt);

        // Boîte de volants
        $shuttlecocks = new Product();
        $shuttlecocks->setTitle('Boîte de volants')
                      ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
                      ->setPrice(30)
                      ->setSize('') // no size
                      ->setPicture('shuttlecocks.jpg');
        $manager->persist($shuttlecocks);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['products'];
    }
}
