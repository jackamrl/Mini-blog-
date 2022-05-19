<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



use App\Entity\profil;
use App\Entity\Comptes;
use App\Repository\ComptesRepository;


class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(ComptesRepository $repo): Response
    {   

        $compte = $repo->findAll();

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'compte' => $compte
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('profil/home.html.twig');
    }

    /**
     * @Route("profil/new", name="profil_create")
     * @Route("/profil/{id}/edit", name="profil_edit")
     */
    public function form(Comptes $profil = null, Request $requette, ObjectManager $manager){
        if(!$profil) {
            $profil = new Comptes();
        }
        

        $form = $this->createFormBuilder($profil)
                    ->add('title', TextType ::class, [
                        'attr'=> [
                            'placeholder' => "Nom d'utilisateur", 'class' => 'form-control'
                        ]
                    ])
                    ->add('content', TextareaType :: class, [
                        'attr'=> [
                            'placeholder' => "Competences", 'class' => 'form-control'
                        ]
                    ])
                    ->add('image', TextType ::class, [
                        'attr'=> [
                            'placeholder' => "Photo de profil", 'class' => 'form-control'
                        ]
                    ])
                    
                    ->getForm();
        $form->handleRequest($requette);

        if($form->isSubmitted() && $form->isValid()){
            if(!$profil->getId()) {
                $profil->setCreatedAt(new \DateTime());
            }
            $manager->persist($profil);
            $manager->flush();

            return $this->redirectToRoute('profil_show', ['id' => $profil->getId()]);

        }
        ;

        return $this->render('profil/create.html.twig', [
            'formProfil' => $form->createView(),
            'editMode'=> $profil->getId() !==null
            ]);
    }

    /**
     * @Route ("/profil/{id}", name ="profil_show")
     */
    public function show(Comptes $compte) {

        return $this->render('profil/show.html.twig' , [
            'comptes'=>$compte ]); 
    }


}
