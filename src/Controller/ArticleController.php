<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticleController extends AbstractController
{

    /**
     * @Route("/admin/creer-un-article", name="create_article", methods={"GET|POST"})
     * @param Request $request
     * @return Response
     */
    public function createArticle(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        # Nouvelle instance de la classe article (entity)
        $article = new Article();

        # Matérialisation du formulaire déclaré dans ArticleType.php
        $form = $this->createForm(ArticleType::class, $article);

        # handleRequest() sert à récupérer les données du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            # Récupération des données du formulaire
            $article = $form->getData();

            # Récupération du fichier du formulaire
            $file = $form->get('photo')->getData();


            # Définition de l'alias grâce à slugger, basé sur le titre. Slugger supprime les espaces et les caractères indésirables.
            $article->setAlias($slugger->slug($article->getTitle()));

            if ($file) {

                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                $extension = '.' . $file->guessExtension();

                $safeFilename = $slugger->slug($originalFileName);

                $newFilename = $safeFilename . '-' . uniqid() . $extension;

                try {
                    $file->move('uploads_dir', $newFilename);
                    $article->setPhoto($newFilename);
                } catch (FileException $exception) {
                    dd($exception);
                }
            }

            # Création du conteneur et insertion en base de données grâce à Doctrine et l'outil entityManager.
            $entityManager->persist($article);

            # On vide l'entity manager des données précédement contenues.
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez créé un nouvel article !');

            # Redirection sur la page d'accueil
            return $this->redirectToRoute('default_home');
        }

        return $this->render('article/form_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
