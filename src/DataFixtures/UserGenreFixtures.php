<?php

namespace App\DataFixtures;

use App\Entity\AgenceStatus;
use App\Entity\UtilisateurGenre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserGenreFixtures extends Fixture
{
    public const GENRE = [];
    public function load(ObjectManager $manager): void
    {
        $allGenre = [];

        $genre = new UtilisateurGenre();
        $genre->setLibelle("Homme");
        $manager->persist($genre);
        $allGenre['genre_1'] = $genre;

        $genre = new UtilisateurGenre();
        $genre->setLibelle("Femme");
        $manager->persist($genre);
        $allGenre['genre_2'] = $genre;

        $genre = new UtilisateurGenre();
        $genre->setLibelle("Autre");
        $manager->persist($genre);
        $allGenre['genre_3'] = $genre;

        $manager->flush();

        $this->addReference(self::GENRE, $allGenre);
    }
}