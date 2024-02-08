<?php

namespace App\DataFixtures;

use App\Entity\UserGender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserGenreFixtures extends Fixture
{
    const GENDERS = ['homme', 'femme', 'autre'];

    public function load(ObjectManager $manager)
    {
        foreach (self::GENDERS as $label) {
            $gender = new UserGender();
            $gender->setLibelle($label);

            $manager->persist($gender);
            $this->addReference("gender_" . $label, $gender);
        }

        $manager->flush();
    }
}