<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function register(Request $request): Response
    {
        # Nouvelle instance de la classe user (entity)
        $user = new User();

        # Matérialisation du formulaire déclaré dans RegisterType.php
        $form = $this->createForm(RegisterType::class, $user);

        # handleRequest() sert à récupérer les données du formulaire
        $form->handleRequest($request);

        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
