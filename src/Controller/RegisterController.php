<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request): Response //permet de manipuler l'objet request pour savoir si le formulaire est correct
    {

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        //Injection de dependance
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $doctrine = $doctrine->getManager();
            
            $user = $form->getData();

            // dd($user); // dd permet d'analyser ce qu'il y a dans la variable $user

            $doctrine->persist($user);
            $doctrine->flush();
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
