<?php

namespace App\DataFixtures;

use App\Entity\Agence;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Validator\Constraints\Date;

class AgenceFixtures extends Fixture implements DependentFixtureInterface
{
    public const AGENCES = [
        [
            "nom" => "Aventure Horizon",
            "mail" => "info@aventurehorizon.com",
            "domaine" => "www.aventurehorizon.com",
            "city" => 03001,
        ],
        [
            "nom" => "Escale Découverte",
            "mail" => "contact@escaledécouverte.travel",
            "domaine" => "www.escaledécouverte.travel",
            "city" => 22001,
        ],
        [
            "nom" => "Destinations Enchantées",
            "mail" => "info@destinationsenchantées.net",
            "domaine" => "www.destinationsenchantées.net",
            "city" => 19001,
        ],
        [
            "nom" => "Voyages Magiques",
            "mail" => "contact@voyagesmagiques.org",
            "domaine" => "www.voyagesmagiques.org",
            "city" => 47001,
        ],
        [
            "nom" => "ExplorePlus",
            "mail" => "Voyagesinfo@exploreplusvoyages.com",
            "domaine" => "www.exploreplusvoyages.com",
            "city" => 88001,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $allStatus = [$this->getReference("agence_status_1"), $this->getReference("agence_status_2"), $this->getReference("agence_status_3")];

        foreach (self::AGENCES as $index=>$thisAgence) {
            $agence = new Agence();
            $agence->setNom($thisAgence['nom']);
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