<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Entity\Travelers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $client = $this->getReference('client');

        $invoice = new Invoice();
        $invoice->setQuote($this->getReference('devis_1'));
        $invoice->setTerms("Paiement attendu de la part de la personne suivante : ");
        $invoice->setPaymentStatus(1);
        $invoice->setPaymentLastname($client->getLastName());
        $invoice->setPaymentFirstname($client->getFirstName());
        $invoice->setPaymentEmail($client->getEmail());
        $invoice->setPaymentPhone($client->getPhone());
        $invoice->setPaymentAddress($client->getAddress());
        $invoice->setPaymentCity($client->getCity());

        $manager->persist($invoice);
        $this->addReference("invoice" . 1, $invoice);

        foreach ([25, 29, 15] as $travelerAge) {
            $traveler = new Travelers();
            $traveler->setLastname($faker->lastName);
            $traveler->setFirstname($faker->firstName);
            $traveler->setAge($travelerAge);
            $traveler->setInvoice($invoice);

            $manager->persist($traveler);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuotationClientFixtures::class,
        ];
    }
}