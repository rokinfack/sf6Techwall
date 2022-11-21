<?php

namespace App\service;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class Helpers 
{
    
    public function __construct(private LoggerInterface $logger,Security $security){

    }
   

    public function sayCc():string{
        $this->logger->info('hello');
        return 'cc';
    }
    public function getUser():User{
        return $this->security->getUser();
    }
}