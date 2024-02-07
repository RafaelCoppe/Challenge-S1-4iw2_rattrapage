<?php

namespace App\DataFixtures;

use App\Entity\AgenceStatus;
use App\Entity\DevisStatus;
use App\Entity\FacturePaymentStatus;
use App\Entity\UtilisateurStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class FacturePaymentStatusFixtures extends Fixture
{
    const STATUS = ['payé', 'non payé', 'partiellement payé'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $index=>$label) {
            $status = new FacturePaymentStatus();
            $status->setLibelle($label);

            $manager->persist($status);
        }

        $manager->flush();
    }
}