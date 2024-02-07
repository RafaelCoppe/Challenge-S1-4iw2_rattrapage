<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $role = ($this->getReference("role_user"));
        $genders = [$this->getReference("gender_homme"), $this->getReference("gender_femme"), $this->getReference("gender_autre")];
        $status = [$this->getReference("user_status_1"), $this->getReference("user_status_2"), $this->getReference("user_status_3"), $this->getReference("user_status_4")];
        $villes = [21001, 68280, 97601, 59001, 59477, 49381, 49002, 68001, 25004, 25001];

        for($i=0; $i<10; $i++) {
            $nameGender = ($i%2 == 0 ? 'male' : 'female');
            $lastname = $faker->lastName($nameGender);
            $firstname = $faker->firstName($nameGender);
            $gender = ([$i%2 == 0 ? $genders[0] : $genders[1], $genders[2]]);

            $user = new Utilisateur();
            $user->setUsername(utf8_encode(strtolower("$firstname[0]$lastname")));
            $user->setPassword("12345");
            $user->setPrenom(utf8_encode($firstname));
            $user->setNom(utf8_encode($lastname));
            $user->setMail(utf8_encode("$firstname.$lastname@mail.com"));
            $user->setTel($faker->phoneNumber);
            $user->setAdresse(utf8_encode($faker->streetAddress));
            $user->setCity($villes[$i]);
            $user->setGenre($gender[rand(0, 1)]);
            $user->setStatus($status[$i%4]);
            $user->setRole($role);
            $user->setCreateDate(new DateTime('now', new DateTimeZone("Europe/Paris")));

            $nb = rand(0, 5);
            if($nb!=0){
                $agences_array = range(1, 5);
                shuffle($agences_array );
                $agences_array = array_slice($agences_array ,0,$nb);

                foreach ($agences_array as $uneAgence) {
                    $uneAgence = $this->getReference('agence_' . $uneAgence);

                    $user->addAgence($uneAgence);
                }
            }

            $manager->persist($user);
            $this->addReference("user_" . $i+1, $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgenceFixtures::class,
            UserGenreFixtures::class,
            UserRoleFixtures::class,
            UserStatusFixtures::class
        ];
    }
}