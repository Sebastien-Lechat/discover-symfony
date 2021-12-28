<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{

    /**
     * @Route("/admin/creer-un-article.html", name="create_article", methods={"GET|POST"})
     * @param Request $request
     * @return Response
     */
    public function createArticle(Request $request, SluggerInterface $slugger): Response
    {
        # Nouvelle instance de la classe article (entity)
        $article = new Article();

        # Matérialisation du formulaire déclaré dans ArticleType.php
        $form = $this->createForm(ArticleType::class, $article);

        # handleRequest() sert à récupérer les données du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($article);
        }

        return $this->render('article/form_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
