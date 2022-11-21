<?php


namespace App\EventListener;

use App\Event\AddPersonneEvent;
use Psr\Log\LoggerInterface;

class PersonneListener 
{
    public function __construct(private LoggerInterface $logger)
    {
        
    }

    public function onPersonneAdd(AddPersonneEvent $event)
    {

       $this->logger->debug("cc je suis entrain d'ecouter personne.add et une personne vient d'etre ajoutée et c'est " . $event->getPersonne()->getName());
    }
}

