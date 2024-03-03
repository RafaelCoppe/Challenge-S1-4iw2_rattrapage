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
        [
            ["unitprice" => 55, "quantity" => 5, "additional" => "Hotel 'Le Palmier', 17 avenue des champs", "product" => 6],
            ["unitprice" => 50, "quantity" => 3, "additional" => "Restaurant 'La Cantina', 8 rue du Cap", "product" => 8],
            ["unitprice" => 100, "quantity" => 1, "additional" => "Visite du musée de la mer pour deux personnes", "product" => 3],
        ],
        [
            ["unitprice" => 400, "quantity" => 1, "additional" => "Location d'une Audi chez Swift", "product" => 1],
            ["unitprice" => 50, "quantity" => 1, "additional" => "Hotel B&B Marseille", "product" => 6],
            ["unitprice" => 60, "quantity" => 1, "additional" => "Hotel B&B Nice", "product" => 6],
            ["unitprice" => 10, "quantity" => 2, "additional" => "Petit déjeuner à l'hotel B&B Marseille", "product" => 9],
            ["unitprice" => 10, "quantity" => 2, "additional" => "Petit déjeuner à l'hotel B&B Nice", "product" => 9],
        ],
        [
            ["unitprice" => 30, "quantity" => 2, "additional" => "Taxi professionnel sur 10 km", "product" => 2],
            ["unitprice" => 150, "quantity" => 3, "additional" => "Hotel 4 étoiles", "product" => 6],
            ["unitprice" => 50, "quantity" => 3, "additional" => "Restaurant gastronomique", "product" => 8],
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::LINES as $index=>$lines) {
            foreach ($lines as $obj) {
                $line = new Line();
                $line->setQuote($this->getReference('devis_' . $index+1));
                $line->setPlace($index+1);
                $line->setUnitPrice($obj['unitprice']);
                $line->setQuantity($obj['quantity']);
                $line->setAdditional($obj['additional']);
                $line->setProduct($this->getReference('produit_' . $obj['product']));
            }

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