<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $status = ['active', 'inactive', 'suspended', 'deleted'];
        $villes = [21001, 68280, 97601, 59001, 59477, 49381, 49002, 68001, 25004, 25001];

        for($i=0; $i<10; $i++) {
            $gender = ($i%2 == 0 ? 'male' : 'female');
            $lastname = $faker->lastName($gender);
            $firstname = $faker->firstName($gender);

            $user = new User();
            $user->setUsername(strtolower("$firstname[0]$lastname"));
            $user->setPassword("12345");
            $user->setFirstName(utf8_encode($firstname));
            $user->setLastName(utf8_encode($lastname));
            $user->setMail(utf8_encode("$firstname.$lastname@mail.com"));
            $user->setPhone($faker->phoneNumber);
            $user->setAddress(utf8_encode($faker->streetAddress));
            $user->setCity($villes[$i]);
            $user->setGender($gender == 'male' ? 'homme' : 'femme');
            $user->setStatus($status[$i%4]);
            $user->setRoles(["ROLE_USER"]);
            $user->setCreateDate(new DateTime('now', new DateTimeZone("Europe/Paris")));

            $nb = rand(0, 5);
            if($nb!=0){
                $agences_array = range(1, 5);
                shuffle($agences_array );
                $agences_array = array_slice($agences_array ,0,$nb);

                foreach ($agences_array as $uneAgence) {
                    $uneAgence = $this->getReference('agence_' . $uneAgence);

                    $user->addAgency($uneAgence);
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
        ];
    }
}