<?php

namespace App\DataFixtures;

use App\Entity\AgencyStatus;
use App\Entity\UserStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserStatusFixtures extends Fixture
{
    const STATUS = ['active', 'inactive', 'suspended', 'deleted'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $index=>$label) {
            $status = new UserStatus();
            $status->setLibelle($label);

            $manager->persist($status);
            $this->addReference("user_status_" . $index+1, $status);
        }

        $manager->flush();
    }
}