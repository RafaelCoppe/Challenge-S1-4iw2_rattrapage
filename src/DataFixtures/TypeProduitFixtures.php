<?php

namespace App\DataFixtures;

use App\Entity\ProduitType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeProduitFixtures extends Fixture
{
    const TYPE = ['reservation', 'location', 'sortie', 'logement'];

    public function load(ObjectManager $manager)
    {
        foreach (self::TYPE as $label) {
            $type = new ProduitType();
            $type->setLibelle($label);

            $manager->persist($type);
            $this->addReference("produit_type_" . $label, $type);
        }

        $manager->flush();
    }
}