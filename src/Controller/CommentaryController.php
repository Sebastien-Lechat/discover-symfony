<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentary;
use App\Form\CommentaryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaryController extends AbstractController
{
    /**
     * @Route("/add/commentary?article_id={id}", name="add_commentary", methods={"GET|POST"})
     */
    public function addCommentary(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {   
        $commentary = new Commentary();

        $form = $this->createForm(CommentaryType::class, $commentary);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commentary = $form->getData();

            $commentary->setAuthor($this->getUser());

            $commentary->setArticle($article);

            $entityManager->persist($commentary);

            $entityManager->flush();

            $this->addFlash('success', 'Vous avez créé un nouveau commentaire !');

            return $this->redirectToRoute('show_article', [ 'id' => $article->getId() ]);
        }

        return $this->render('rendered/form_commentary.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
