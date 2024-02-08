<?php

namespace App\DataFixtures;

use App\Entity\AgencyStatus;
use App\Entity\QuotationStatus;
use App\Entity\InvoicePaymentStatus;
use App\Entity\UserStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class FacturePaymentStatusFixtures extends Fixture
{
    const STATUS = ['payé', 'non payé', 'partiellement payé'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $index=>$label) {
            $status = new InvoicePaymentStatus();
            $status->setLibelle($label);

            $manager->persist($status);
        }

        $manager->flush();
    }
}