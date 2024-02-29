<?php

namespace App\EventListener;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Member::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Member::class)]
class MemberPassword
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher){}

    public function prePersist(Member $member): void
    {
        $this->updatePassword($member);
    }

    public function preUpdate(Member $member): void
    {
        $this->updatePassword($member);
    }

    private function updatePassword(Member $member): void
    {
        $member->setPassword($this->passwordHasher->hashPassword($member, $member->getPassword()));
    }
}