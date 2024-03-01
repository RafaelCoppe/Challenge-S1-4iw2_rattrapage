<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    const PRODUITS = [
        ["transport", "Location de voiture", 5],["transport", "Taxi de l'aéroport à l'hôtel", 10],
        ["activité", "Visite d'un musée", 5],["activité", "Randonnée", 0],["activité", "Visite guidée de la ville", 0],
        ["logement", "Chambre d'hôtel", 10],["logement", "Location d'un AirBnB", 10],
        ["restauration", "Réservation d'une table dans un restaurant", 0],["restauration", "Petit-déjeuner à l'hôtel", 0],
        ["other", "Journée libre", 0]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PRODUITS as $index=>$obj) {
            $produit = new Product();
            $produit->setLabel($obj[0]);
            $produit->setCategory($obj[1]);
            $produit->setTax($obj[2]);
            $produit->setAgency($this->getReference('agence_1'));

            $manager->persist($produit);
            $this->addReference("produit_" . $index+1, $produit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgencyFixtures::class,
        ];
    }
}