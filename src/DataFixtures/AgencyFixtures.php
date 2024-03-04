<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AgencyFixtures extends Fixture
{
    public const AGENCES = [
        [
            "name" => "Aventure Horizon",
            "mail" => "info@aventurehorizon.com",
            "domain" => "www.aventurehorizon.com",
            "city" => 23001,
        ],
        [
            "name" => "Escale Découverte",
            "mail" => "contact@escaledécouverte.travel",
            "domain" => "www.escaledécouverte.travel",
            "city" => 22001,
        ],
        [
            "name" => "Destinations Enchantées",
            "mail" => "info@destinationsenchantées.net",
            "domain" => "www.destinationsenchantées.net",
            "city" => 19001,
        ],
        [
            "name" => "Voyages Magiques",
            "mail" => "contact@voyagesmagiques.org",
            "domain" => "www.voyagesmagiques.org",
            "city" => 47001,
        ],
        [
            "name" => "ExplorePlus",
            "mail" => "Voyagesinfo@exploreplusvoyages.com",
            "domain" => "www.exploreplusvoyages.com",
            "city" => 88001,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $allStatus = ['valid', 'deleted', 'suspended'];

        foreach (self::AGENCES as $index=>$thisAgence) {
            $agence = new Agency();
            $agence->setName($thisAgence['name']);
            $agence->setDescription($faker->text);
            $agence->setAddress($faker->streetAddress);
            $agence->setCity($thisAgence['city']);
            $agence->setPhone($faker->phoneNumber);
            $agence->setMail($thisAgence['mail']);
            $agence->setStatus($allStatus[0]);
            $agence->setDomain($thisAgence['domain']);
            $agence->setCreateDate(new DateTime('now', new DateTimeZone("Europe/Paris")));

            $manager->persist($agence);
            $this->addReference("agence_" . $index+1, $agence);
        }

        $manager->flush();
    }
}