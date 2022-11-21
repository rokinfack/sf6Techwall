<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $profile=new Profile();

       $profile->setRs('Facebook');
       $profile->setUrl("https://www.facebook.com/rostand.kinfack/");

       $profile1=new Profile();

       $profile1->setRs('LinkedIn');
       $profile1->setUrl("https://www.linkedin.com/in/kinfack-rostand-68a35522a/");

       $profile2=new Profile();

       $profile2->setRs('Github');
       $profile2->setUrl("https://github.com/rokinfack");

    $manager->persist($profile);
    $manager->persist($profile1);
    $manager->persist($profile2);

        $manager->flush();
    }
}
