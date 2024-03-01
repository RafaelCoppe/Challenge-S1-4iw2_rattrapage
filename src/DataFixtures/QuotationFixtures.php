<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Entity\Product;
use App\Entity\Quotation;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class QuotationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $quote = new Quotation();
        $quote->setTerms("Voyage pour deux personnes dans le sud de la France, avec hébergement à l'hotel");
        $quote->setStatus("Brouillon");
        $quote->setDuration(5);
        $quote->setAgency($this->getReference('agence_1'));
        $quote->setStartDate(DateTime::createFromFormat('d/m/Y', '12/02/2024'));
        $quote->setEndDate(DateTime::createFromFormat('d/m/Y', '16/02/2024'));

        $manager->persist($quote);
        $this->addReference("devis_" . 1, $quote);

        $manager->flush();
    }
}