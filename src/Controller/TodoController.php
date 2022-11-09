<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;


#[Route("/todo")]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {

        $session=$request->getSession();

        if(!$session->has('todos')){
            $todos=[
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens',
            ];


            $session->set('todos',$todos);
            $this->addFlash('info', "la liste des todos viens d'etre initialisée");

        }

        return $this->render('todo/index.html.twig');
    }
    
    #[Route('/add/{name?test}/{content?test}',
     name:'todo.add')]

    public function addTodo(Request $request,$name,$content){

        $session=$request->getSession();

        if($session->has('todos')){

            $todos=$session->get('todos');

            if(isset($todos[$name])){
                $this->addFlash('error',"la liste fes todos n'est pas encore initialisé");

            }else{
                $todos[$name]=$content;
                $session->set('todos',$todos);
                $this->addFlash('success',"la liste fes todos  $name à ete ajouté avec successn'est pas encore initialisé");

            }

        }else{
            $this->addFlash('error',"la liste fes todos n'est pas encore initialisé");

        }


       
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/update/{name}/{content}',name:'app_update')]
    public function updateTodo(Request $request,$name,$content){

        $session=$request->getSession();

        if($session->has('todos')){

            $todos=$session->get('todos');

            if(isset($todos[$name])){

                if($todos[$name]==$content){
                    $this->addFlash('error',"vous avez déjà faire la mise à jour de $name avec le meme nom");
                
                }else{
                    $todos[$name]=$content;

                $session->set('todos',$todos);
                
                $this->addFlash('success',"le todo $name à été mise a jour");


                }

            }else{

                $this->addFlash('error',"le todo  $name nexiste pas dans la liste");
            }
           
        }
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/delete/{name}',name:'app_delete')]
    public function deleteTodo(Request $request ,$name){

        $session=$request->getSession();

        if($session->has('todos')){

            $todos=$session->get('todos');

            if(isset($todos[$name])){

                unSet($todos[$name]);

                $session->set('todos',$todos);

                $this->addFlash('success',"le todo $name à été supprimé avec succès");

            }else{
                $this->addFlash('error',"le todo  $name nexiste pas dans la liste");
            }


        }else{
            $this->addFlash('error',"la liste fes todos n'est pas encore initialisé");

        }


        return $this->redirectToRoute('app_todo');

    }
    #[Route('/deleteAll',name:'app_delete_all')]
    public function deleteAllTodo(Request $request){

        $session=$request->getSession();

        if($session->has('todos')){
            $todos=$session->get('todos');


            if(!empty($todos)){

                $session->set('todos',[]);

                $this->addFlash('success',"vous venez de suprimer toutes la todoList");

            }else{
                $this->addFlash('error',"La todo d'id est déjà vide");

             }


        }else{
            $this->addFlash('error',"votre todoList n'est pas encore initialisée");
        }

        return $this->redirectToRoute('app_todo');

    }

    #[Route('/todo/addMyTodo',name:'app_myTodo')]
    public function addMyTodo(Request $request):RedirectResponse{

        $session=$request->getSession();

        if($session->has('todos')){

            $todos=$session->get('todos');
            if(empty($todos)){
                $todos=[
                    "Lundi"=>'React',
                    'Mardi'=>"Angular",
                    "Mercredi"=>"Symfony",
                    "Jeudi"=>"Projet Angular",
                    "Vendredi"=>"Laravel",
                    "Samedi"=>"repos"
                ];
                $session->set('todos',$todos);
                $this->addFlash('info',"Votre liste à été ajouté avec succes!");
            }else{
                $this->addFlash('worning',"Suprimer tous les élément pour continuer");

             }
        }else{
            $this->addFlash('error',"votre todoList n'est pas encore initialisée");

        }


        return $this->redirectToRoute('app_todo');

    }

    #[Route('/reset', name:'app.reset')]

    public function resetTodo(Request $request):RedirectResponse{

        $session=$request->getSession();

        $session->remove('todos');

        return $this->redirectToRoute('app_todo');


    }
   


}


