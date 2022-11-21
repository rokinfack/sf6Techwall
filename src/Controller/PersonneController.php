<?php

namespace App\Controller;


use App\Entity\Personne;
use App\service\Helpers;
use App\Form\PersonneType;
use App\service\FileUpload;
use Psr\Log\LoggerInterface;

use App\service\MailerService;
use App\Event\AddPersonneEvent;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


 #[Route('/personne')]
class PersonneController extends AbstractController
{
    
    public function __construct(
        private LoggerInterface $logger,
        private Helpers $helper,
        private EventDispatcherInterface $dispatcher
        ){}
    

    #[Route('/', name:'personne.list')]
    public function index(ManagerRegistry $doctrine,)
    {
       
        $repository=$doctrine->getRepository(Personne::class);

         $personnes=$repository->findAll();
        return $this->render("personne/index.html.twig",
    [
        'personnes'=>$personnes
    ]);

    }
    #[Route('/alls/age/{ageMin}/{ageMax}', name:'personne.age')]
    public function personneAge(ManagerRegistry $doctrine,$ageMax,$ageMin)
    {
        $repository=$doctrine->getRepository(Personne::class);

        $personnes=$repository->findByAgeInterval($ageMin,$ageMax);
        

        return $this->render("personne/index.html.twig",
    [
        'personnes'=>$personnes
    ]);

    }
    #[Route('/alls/stats/{ageMin}/{ageMax}', name:'personne.state')]
    public function statsPersonneAge(ManagerRegistry $doctrine,$ageMax,$ageMin)
    {
        $repository=$doctrine->getRepository(Personne::class);

        $stats=$repository->findByAgeIntervalStats($ageMin,$ageMax);

       
        return $this->render("personne/stats.html.twig",
    [
        'stats'=>$stats[0],
        'ageMin'=>$ageMin,
        'ageMax'=>$ageMax

    ]);

    }

    #[
        Route("/delete/{id}", name:"personne.delete"),

        isGranted('ROLE_ADMIN')
    ]
    public function deletePersonne(Personne $personne=null,ManagerRegistry $doctrine):Response{

        if($personne){
            $manger=$doctrine->getManager();
            $manger->remove($personne);

            $manger->flush();
            $this->addFlash(type:"success",message:'la personne a été bien supprimée avec succès');
        }else{
            $this->addFlash(type:"error",message:'la personne innexistante');

        }

        return $this->redirectToRoute("personne.list.alls");

    }

    #[Route('/update/{id}/{name}/{firstname}/{age}', name:"personne.update")]
    public function update(Personne $personne=null,$name,$firstname,$age,ManagerRegistry $doctrine):Response{

        if($personne){

            $personne->setFirstname($firstname);
            $personne->setName($name);
            $personne->setAge($age);

            $manager=$doctrine->getManager();

            $manager->persist($personne);

            $manager->flush();
            $this->addFlash(type:"success",message:'la personne a été mis à jour avec succès');
        }else{
            $this->addFlash(type:"error",message:'la personne innexistante');
        }
        return $this->redirectToRoute("personne.list.alls");
    }



        #[
            Route('/alls/{page?1}/{nb?15}',
             name:'personne.list.alls'),
             IsGranted("ROLE_USER")
             ]
        public function indexAlls(ManagerRegistry $doctrine, $page,$nb)
        {
            $repository=$doctrine->getRepository(Personne::class);

            $nbPersonne=$repository->count([]);

            $nbPage = ceil($nbPersonne/$nb);
         $personnes=$repository->findBy([],[],limit:$nb,offset:($page-1)*$nb );

        return $this->render("personne/index.html.twig",
    [
        'personnes'=>$personnes,
        'nbPage'=>$nbPage,
        'isPaginate'=>true,
        'page'=>$page,
        'nbre'=>$nb
    ]);

    }

    #[Route('/{id<\d+>}', name:'personne.detail')]
    public function detailPersonne(Personne $personne=null)
    {
    
        if(!$personne){
            $this->addFlash(type:"error",message:"la personne d'id $personne cherchez n'existe pas");
            return $this->redirectToRoute('personne.lis');
        }else{
            return $this->render("personne/detail.html.twig",[
                'personne'=>$personne
            ]);

        }

    }
    


    #[Route('/edit/{id?0}', name: 'personne.edit')]
    public function addPersonne( 
        FileUpload $upload,
        Personne $personne=null,
        ManagerRegistry $doctrine,
        Request $request,
        MailerService $mailer
    
        ): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $new=false;
    $entityManager=$doctrine->getManager();

    if(!$personne ){
        $new=true;
        $personne=new Personne();
    }

    $form = $this->createForm(PersonneType::class, $personne);
    $form->remove('createdAt');
    $form->remove('updatedAt');

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $manager=$doctrine->getManager();


        if($new){
            $message= " a été ajouté avec succès";
            
            $personne->setCreatedBy($this->getUser());
        }else{
            $message= " a été mis à jour avec succès";
        }

        $manager->persist($personne);


if ($form->isSubmitted() && $form->isValid()) {
    /** @var UploadedFile $brochureFile */
    $photo = $form->get('photo')->getData();



    if ($photo) {

        $directory=$this->getParameter('personne_directory');
 // instead of its contents
        $personne->setImage($upload->uploadFile($photo,$directory));

    }
}
  
    $mailMessage=$personne->getFirstname().' '.$personne->getName(). " ".$message;

    $mailer->sendEmail(content:$mailMessage);



        $manager->flush();
        if($new){
            $addPersonneEvent=new AddPersonneEvent($personne);
            $this->dispatcher->dispatch($addPersonneEvent, AddPersonneEvent::ADD_PERSONNE_EVENT);
        }
 
        $this->addFlash(type:$personne->getName(), message:"l'image a été ajouté avec succès");
        return $this->redirectToRoute("personne.list");

    } else {
       
        return $this->render('personne/add-personne.html.twig', [
            'form'=>$form->createView()

        ]);
    }
}
}
