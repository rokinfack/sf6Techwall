<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture implements FixtureGroupInterface
{

    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager){  
        $this->manager = $manager;
        $admin=new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($this->userPasswordHasherInterface->hashPassword($admin,'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin1=new User();
        $admin1->setEmail('admin1@gmail.com');
        $admin1->setPassword($this->userPasswordHasherInterface->hashPassword($admin1,'admin'));
        $admin1->setRoles(['ROLE_USER']);
        $admin2=new User();
        $admin2->setEmail('admin2@gmail.com');
        $admin2->setPassword($this->userPasswordHasherInterface->hashPassword($admin2,'admin'));
        $admin2->setRoles(['ROLE_USER']);

        $manager->persist($admin);
        $manager->persist($admin1);
        $manager->persist($admin2);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
