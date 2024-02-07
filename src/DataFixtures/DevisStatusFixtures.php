<?php

namespace App\DataFixtures;

use App\Entity\AgenceStatus;
use App\Entity\DevisStatus;
use App\Entity\UtilisateurStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class DevisStatusFixtures extends Fixture
{
    const STATUS = ['refusé', 'validé'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $index=>$label) {
            $status = new DevisStatus();
            $status->setLibelle($label);

            $manager->persist($status);
        }

        $manager->flush();
    }
}