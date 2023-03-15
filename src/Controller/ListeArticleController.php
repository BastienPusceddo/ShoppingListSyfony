<?php

namespace App\Controller;

use App\Entity\ListeCourse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeArticleController extends AbstractController
{
    #[Route('/liste/{id}/listeArticle', name: 'app_liste_article',methods: ['GET'])]
    public function index(ListeCourse $listeCourse): Response
    {
        return $this->render('liste_article/index.html.twig', [
            'controller_name' => 'ListeArticleController',
            'listeCourse' => $listeCourse
        ]);
    }
}
