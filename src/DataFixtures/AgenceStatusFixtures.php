<?php

namespace App\DataFixtures;

use App\Entity\AgenceStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AgenceStatusFixtures extends Fixture
{
    const STATUS = ['valid', 'deleted', 'suspended'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $index=>$label) {
            $status = new AgenceStatus();
            $status->setLibelle($label);

            $manager->persist($status);
            $this->addReference("agence_status_" . $index+1, $status);
        }

        $manager->flush();
    }
}