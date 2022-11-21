<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class Person extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr-FR');

        for($i=0; $i<100 ; $i++){

            $personne= new Personne();

            $personne->setFirstname($faker->firstname);
            $personne->setName($faker->name);
            $personne->setAge($faker->numberBetween(18,60));
        

            $manager->persist($personne);

        }

        $manager->flush();
    }
}
