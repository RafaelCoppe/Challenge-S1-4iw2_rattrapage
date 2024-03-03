<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Entity\Line;
use App\Entity\Product;
use App\Entity\Quotation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class QuotationLineFixtures extends Fixture implements DependentFixtureInterface
{
    const LINES = [
        [55, 5, "Hotel 'Le Palmier', 17 avenue des champs", 6],
        [50, 3, "Restaurant 'La Cantina', 8 rue du Cap", 8],
        [100, 1, "Visite du musée de la mer pour deux personnes", 3],
    ];

    const LINES_REMISE = [
        [55, 5, "Hotel 'Le Palmier', 17 avenue des champs", 6],
        [50, 3, "Restaurant 'La Cantina', 8 rue du Cap", 8],
        [100, 1, "Visite du musée de la mer pour deux personnes", 3],
        [10, 1, "Remise de 10% due à une erreur de réservation d'un hotel lors d'un précedent voyage avec l'agence", 11],
    ];

    public function load(ObjectManager $manager)
    {
        // Devis sans remise
        foreach (self::LINES as $index=>$obj) {
            $line = new Line();
            $line->setQuote($this->getReference('devis_1'));
            $line->setPlace($index+1);
            $line->setUnitPrice($obj[0]);
            $line->setQuantity($obj[1]);
            $line->setAdditional($obj[2]);
            $line->setProduct($this->getReference('produit_' . $obj[3]));

            $manager->persist($line);
        }

        // Devis avec remise
        foreach (self::LINES_REMISE as $index=>$obj) {
            $line = new Line();
            $line->setQuote($this->getReference('devis_2'));
            $line->setPlace($index+1);
            $line->setUnitPrice($obj[0]);
            $line->setQuantity($obj[1]);
            $line->setAdditional($obj[2]);
            $line->setProduct($this->getReference('produit_' . $obj[3]));

            $manager->persist($line);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }
}