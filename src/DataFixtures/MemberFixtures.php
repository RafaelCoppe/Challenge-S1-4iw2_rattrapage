<?php

namespace App\DataFixtures;

use App\Entity\Member;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $status = ['active', 'inactive', 'suspended', 'deleted'];
        $villes = [21001, 68280, 97601, 59001, 59477, 49381, 49002, 68001, 25004, 25001];

        for($i=0; $i<10; $i++) {
            $gender = ($i%2 == 0 ? 'male' : 'female');
            $lastname = utf8_encode($faker->lastName($gender));
            $firstname = utf8_encode($faker->firstName($gender));

            $member = new Member();
            $member->setUsername(strtolower("$firstname[0]$lastname"));
            $member->setPassword("12345");
            $member->setFirstName($firstname);
            $member->setLastName($lastname);
            $member->setMail("$firstname.$lastname@mail.com");
            $member->setPhone($faker->phoneNumber);
            $member->setAddress(utf8_encode($faker->streetAddress));
            $member->setCity($villes[$i]);
            $member->setGender($gender == 'male' ? 'homme' : 'femme');
            $member->setStatus($status[$i%4]);
            $member->setRoles(["ROLE_USER"]);
            $member->setCreateDate(new DateTime('now', new DateTimeZone("Europe/Paris")));

            $nb = rand(0, 5);
            if($nb!=0){
                $agences_array = range(1, 5);
                shuffle($agences_array );
                $agences_array = array_slice($agences_array ,0,$nb);

                foreach ($agences_array as $uneAgence) {
                    $uneAgence = $this->getReference('agence_' . $uneAgence);

                    $member->addAgency($uneAgence);
                }
            }

            $manager->persist($member);
            $this->addReference("user_" . $i+1, $member);
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