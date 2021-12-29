<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaryController extends AbstractController
{
    /**
     * @Route("/add/commentary?article_id={id}", name="add_commentary", methods="{GET|POST}")
     */
    public function addCommentary(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('commentary/index.html.twig', [
            'controller_name' => 'CommentaryController',
        ]);
    }
}
