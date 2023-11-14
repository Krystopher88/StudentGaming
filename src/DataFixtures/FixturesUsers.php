<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use faker;

class FixturesUsers extends Fixture
{

    public function __construct(
        private SluggerInterface $sluggerInterface,
        private UserPasswordHasherInterface $userPasswordHasherInterface
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@studentgaming.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->userPasswordHasherInterface->hashPassword($admin, 'admin')
        );
        $admin->setLastname('Dent');
        $admin->setFirstName('Arthur');
        $admin->setAddress('42 rue du guide');
        $admin->setZipCode('42000');
        $admin->setCity('Viltvodle VI');

        $manager->persist($admin);

        $faker = \Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 10; $usr++){
            $users = new Users();
            $users->setEmail($faker->email);
            $users->setPassword(
                $this->userPasswordHasherInterface->hashPassword($users, 'user')
            );
            $users->setLastname($faker->lastName);
            $users->setFirstName($faker->firstName);
            $users->setAddress($faker->streetAddress);
            $users->setZipCode(str_replace(' ', '', $faker->postcode));
            $users->setCity($faker->city);

            $manager->persist($users);
        }


        $manager->flush();
    }
}
