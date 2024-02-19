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

class QuotationLineFixtures extends Fixture
{
    const LINES = [
        [55, 5, "Hotel 'Le Palmier', 17 avenue des champs", 10, 12],
        [50, 3, "Restaurant 'La Cantina', 8 rue du Cap", 10, 3],
        [100, 1, "Visite du musée de la mer pour deux personnes", 5, 8],
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
            $line->setTax($obj[3]);
            $line->setProduct($this->getReference('produit_' . $obj[4]));

            $manager->persist($line);
        }


        $manager->flush();
    }
}