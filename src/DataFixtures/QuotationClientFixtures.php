<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class QuotationClientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $lastname = utf8_encode($faker->lastName);
        $firstname = utf8_encode($faker->firstName);

        $client = new Client();
        $client->setLastName($lastname);
        $client->setFirstName($firstname);
        $client->setEmail("$lastname.$firstname@mail.com");
        $client->setPhone($faker->phoneNumber);
        $client->setAddress("14 impasse des acacias");
        $client->setCity(60342);
        $client->setQuotation($this->getReference('devis_1'));

        $manager->persist($client);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuotationFixtures::class,
        ];
    }
}