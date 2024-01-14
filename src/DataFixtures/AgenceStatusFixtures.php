<?php

namespace App\DataFixtures;

use App\Entity\AgenceStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AgenceStatusFixtures extends Fixture
{
    public const STATUS = [];
    public function load(ObjectManager $manager): void
    {
        $allStatus = [];

        $status = new AgenceStatus();
        $status->setLibelle("valid");
        $manager->persist($status);
        $allStatus['status_1'] = $status;

        $status = new AgenceStatus();
        $status->setLibelle("deleted");
        $manager->persist($status);
        $allStatus['status_2'] = $status;

        $status = new AgenceStatus();
        $status->setLibelle("suspended");
        $manager->persist($status);
        $allStatus['status_3'] = $status;

        $manager->flush();

        $this->addReference(self::STATUS, $allStatus);
    }
}