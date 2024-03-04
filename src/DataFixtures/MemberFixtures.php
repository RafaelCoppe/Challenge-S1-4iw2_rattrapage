<?php

namespace App\DataFixtures;

use App\Entity\Member;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

/*
 * BUg non résolu :
 * Si erreur "Attempted to load class" ou "failed to open stream: No such file or directory"
 * Commenter / Décommenter ligne 18
 */
include('assets/utilities/Encoding.php');
use ForceUTF8\Encoding;
class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $status = ['active', 'inactive', 'suspended', 'deleted'];
        $villes = [21001, 68280, 97601, 59001, 59477, 49381, 49002, 68001, 25004, 25001];

        for($i=0; $i<10; $i++) {
            $gender = ($i%2 == 0 ? 'male' : 'female');
            $lastname = strtolower(Encoding::fixUTF8($faker->lastName($gender)));
            $firstname = strtolower(Encoding::fixUTF8($faker->firstName($gender)));

            $member = new Member();
            $member->setUsername("$firstname[0]$lastname");
            $member->setPassword("12345");
            $member->setFirstName($firstname);
            $member->setLastName($lastname);
            $member->setMail(Encoding::fixUTF8("$firstname.$lastname@mail.com"));
            $member->setPhone(Encoding::fixUTF8($faker->phoneNumber));
            $member->setAddress(Encoding::fixUTF8($faker->streetAddress));
            $member->setCity($villes[$i]);
            $member->setGender($gender == 'male' ? 'homme' : 'femme');
            $member->setStatus($status[0]);
            $member->setRoles(["ROLE_USER"]);
            $member->setCreatedDate(new DateTime('now', new DateTimeZone("Europe/Paris")));
            $member->setAgency($this->getReference('agence_' . rand(1, 5)));

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