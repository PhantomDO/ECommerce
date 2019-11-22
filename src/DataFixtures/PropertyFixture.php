<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++)
        {
            $property = new Property();
            $property
                ->setTitle($faker->words('3', true))
                ->setDescription($faker->sentences('3', true))
                ->setPrice($faker->randomNumber())
                ->setCity($faker->city())
                ->setSold(false);
            $manager->persist($property);
        }

        $manager->flush();
    }
}
