<?php
namespace App\EventListener;

use App\Entity\Quotation;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'createRef', entity: Quotation::class)]
class createQuotationRef
{
    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function createRef(Quotation $quote, PostPersistEventArgs $event): void
    {
        $event->getObject()->setRef(crc32("{$quote->getId()}-{$quote->getAgency()->getId()}"));
        $event->getObjectManager()->persist($event->getObject());
        $event->getObjectManager()->flush();
    }
}