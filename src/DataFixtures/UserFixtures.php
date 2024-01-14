<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $role = ($this->getReference(UserRoleFixtures::ROLES))["role_1"];
        $genders =$this->getReference();

        for ($i = 0; $i < 10; $i++) {
            $user = new Utilisateur();
            $user->setUsername($faker->userName());
            $user->setPassword(12345);
            $user->setNom($faker->name());
            $user->setPrenom($faker->firstName());
            $user->setMail($faker->email());
            $user->setTel($faker->phoneNumber());
            $user->setAdresse($faker->address());
            $user->setCity(01001);
            $user->setGenre(rand(1, 3));
            $user->setStatus(rand(1, 3));
            $user->setCreateDate(new DateTime('now'));
            $user->addAgence(rand(1, 5));
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgenceFixtures::class,
            UserGenreFixtures::class,
            UserRoleFixtures::class
        ];
    }
}