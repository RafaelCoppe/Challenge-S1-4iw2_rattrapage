<?php

namespace App\DataFixtures;

use App\Entity\AgencyStatus;
use App\Entity\QuotationStatus;
use App\Entity\UserStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class DevisStatusFixtures extends Fixture
{
    const STATUS = ['refusé', 'validé'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $index=>$label) {
            $status = new QuotationStatus();
            $status->setLibelle($label);

            $manager->persist($status);
        }

        $manager->flush();
    }
}