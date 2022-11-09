<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstController extends AbstractController
{

    #[Route("/order/{maVar}",name:"app.test.variable")]

    public function maVariable($maVar){
        return new Response(
            "
            <html>
            <body>$maVar</body></html>

            "
        ); 

    }


    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig',[
            'name'=>'rostand',
            'lastName'=>'Kinfack'
        ]);
    }


    #[Route('/sayhello/{name}/{firstName}', name: 'say.hello')]
    public function sayhello($name,$firstName): Response
    {

       
       return $this->render('first/hello.html.twig',[
        'nom'=>$name,
        'prenom'=>$firstName
        
       ]);
    }
    
    #[Route(
        '/multi/{entier1<\d+>}/{entier2<\d+>}',
        name:'app.multi',
        
        )]
    public function multiplication($entier1,$entier2){
        $resultat=$entier1*$entier2;
        return new Response("<h1>$resultat</h1>");
    }
}
