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


    // #[Route('/sayhello/{name}/{firstName}', name: 'say.hello')]
    public function sayhello( $name,$firstname): Response
    {
       return $this->render('first/hello.html.twig',[
        'nom'=>$name,
        'prenom'=>$firstname,
        
        
       ]);
    }
    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        return $this->render('template.html.twig');
    }
    
    #[Route(
        '/multi/{entier1<\d+>}/{entier2<\d+>}',
        name:'app.multi',
        
        )]
    public function multiplication($entier1,$entier2){
        $resultat=$entier1*$entier2;
        return new Response("<h1>$resultat</h1>");
    }


    #[Route('/tab/user', name: 'tab_user')]
    public function user(): Response
    {

        $suers=[
            ['name'=>'sellaouiti','firstname'=>'aymen','age'=>39],
            ['name'=>'Ben slimen','firstname'=>'Ahmed','age'=>30],
            ['name'=>'Abdennebi','firstname'=>'Mohamed','age'=>39],
            ['name'=>'Betrant','firstname'=>'Rodrigues','age'=>6],

        ];

        return $this->render('first/user.html.twig',[
            'users'=>$suers
         ]);
        
    }
    


}
