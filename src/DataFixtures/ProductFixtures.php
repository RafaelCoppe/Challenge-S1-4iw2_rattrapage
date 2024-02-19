<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    const PRODUITS = [
        ["Transport", "reservation"],["Guide", "reservation"],["Restauration", "reservation"],["Autre", "reservation"],
        ["Transport", "location"],["Matériel sportif", "location"],["Autre", "location"],
        ["Culture", "sortie"],["Ballade", "sortie"],["Divertissement", "sortie"],["Autre", "sortie"],
        ["Chambre", "logement"],["Appartement", "logement"],["Mobile_home", "logement"],["Autre", "logement"],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PRODUITS as $index=>$obj) {
            $produit = new Product();
            $produit->setLabel($obj[0]);
            $produit->setType($obj[1]);

            $manager->persist($produit);
            $this->addReference("produit_" . $index+1, $produit);
        }

        $manager->flush();
    }
}