<?php

namespace App\DataFixtures;

use App\Entity\AgenceStatus;
use App\Entity\UtilisateurGenre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserRoleFixtures extends Fixture
{
    public const ROLES = [];
    public function load(ObjectManager $manager): void
    {
        $allRole = [];

        $role = new UtilisateurGenre();
        $role->setLibelle("user");
        $manager->persist($role);
        $allRole['role_1'] = $role;

        $role = new UtilisateurGenre();
        $role->setLibelle("admin");
        $manager->persist($role);
        $allRole['role_2'] = $role;

        $manager->flush();

        $this->addReference(self::ROLES, $allRole);
    }
}