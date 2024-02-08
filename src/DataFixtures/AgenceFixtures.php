<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AgenceFixtures extends Fixture implements DependentFixtureInterface
{
    public const AGENCES = [
        [
            "name" => "Aventure Horizon",
            "mail" => "info@aventurehorizon.com",
            "domain" => "www.aventurehorizon.com",
            "city" => 03001,
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

        $allStatus = [$this->getReference("agency_status_1"), $this->getReference("agency_status_2"), $this->getReference("agency_status_3")];

        foreach (self::AGENCES as $index=>$thisAgence) {
            $agence = new Agency();
            $agence->setName($thisAgence['nom']);
            $agence->setDescription($faker->text);
            $agence->setAdresse($faker->address);
            $agence->setVille($thisAgence['city']);
            $agence->setTel($faker->phoneNumber);
            $agence->setMail($thisAgence['mail']);
            $agence->setStatus($allStatus[$index%3]);
            $agence->setDomaine($thisAgence['domaine']);
            $agence->setConseils($faker->text);
            $agence->setCreateDate(new DateTime('now', new DateTimeZone("Europe/Paris")));

            $manager->persist($agence);
            $this->addReference("agence_" . $index+1, $agence);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgenceStatusFixtures::class,
        ];
    }
}