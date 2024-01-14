<?php

namespace App\DataFixtures;

use App\Entity\Agence;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AgenceFixtures extends Fixture
{
    public const AGENCES = [];
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $allStatus = $this->getReference(AgenceStatusFixtures::STATUS);

        $allAgences = [];
        $agencesData = [
            [
                "nom" => "Aventure Horizon",
                "mail" => "info@aventurehorizon.com",
                "domaine" => "www.aventurehorizon.com"
            ],
            [
                "nom" => "Escale Découverte",
                "mail" => "contact@escaledécouverte.travel",
                "domaine" => "www.escaledécouverte.travel"
            ],
            [
                "nom" => "Destinations Enchantées",
                "mail" => "info@destinationsenchantées.net",
                "domaine" => "www.destinationsenchantées.net"
            ],
            [
                "nom" => "Voyages Magiques",
                "mail" => "contact@voyagesmagiques.org",
                "domaine" => "www.voyagesmagiques.org"
            ],
            [
                "nom" => "ExplorePlus",
                "mail" => "Voyagesinfo@exploreplusvoyages.com",
                "domaine" => "www.exploreplusvoyages.com"
            ],
        ];

        for ($i = 0; $i < 4; $i++) {
            $agence = new Agence();
            $agence->setNom($agencesData[$i]["nom"]);
            $agence->setDescription($faker->text(100));
            $agence->setAdresse($faker->address());
            $agence->setVille(01001);
            $agence->setTel($faker->phoneNumber());
            $agence->setMail($agencesData[$i]["mail"]);
            $agence->setStatus($allStatus[rand(1, 3)]);
            $agence->setDomaine($agencesData[$i]["domaine"]);
            $agence->setCreateDate(new DateTime('now'));
            $agence->setConseils($faker->text());
            $manager->persist($agence);
            $allAgences['agence_' . $i+1] = $agence;
        }

        $this->addReference(self::AGENCES, $allAgences);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgenceStatusFixtures::class,
        ];
    }
}