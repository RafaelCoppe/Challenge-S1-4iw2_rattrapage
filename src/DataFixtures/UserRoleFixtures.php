<?php

namespace App\DataFixtures;

use App\Entity\AgencyStatus;
use App\Entity\UserGender;
use App\Entity\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserRoleFixtures extends Fixture
{
    const ROLES = ['user', 'admin'];

    public function load(ObjectManager $manager)
    {
        foreach (self::ROLES as $label) {
            $role = new UserRole();
            $role->setLibelle($label);

            $manager->persist($role);
            $this->addReference("role_" . $label, $role);
        }

        $manager->flush();
    }
}