<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobs=[
            "Informaticien",
            "Hygiéniste dentaire",
            "Mecanicien",
            "FootBalleur",
            "Physicien",
            "Mathematicien",
            "Chimiste",
            "Medecin"
        ];


        for($i=0; $i<count($jobs); $i++){
            $job=new Job();
            $job->setDesignation($jobs[$i]);

            $manager->persist($job);
            
        }
        $manager->flush();

        $manager->flush();
    }
}
