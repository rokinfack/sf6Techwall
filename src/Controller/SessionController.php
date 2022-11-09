<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index( Request $resquest): Response
    {
        $session=$resquest->getSession();
        if($session->has('nbVisite')){
            $nbreVisi=$session->get('nbVisite')+1;

        }else{
            $nbreVisi=1;
        }
        $session->set('nbVisite',$nbreVisi);
        
        return $this->render('session/index.html.twig');
    }
}
