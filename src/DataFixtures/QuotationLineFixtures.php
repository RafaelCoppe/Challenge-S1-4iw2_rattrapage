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

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

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


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }
}