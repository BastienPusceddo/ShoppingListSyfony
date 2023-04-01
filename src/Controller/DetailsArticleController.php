<?php

namespace App\Controller;

use App\Entity\DetailsArticle;
use App\Entity\ListeCourse;
use App\Form\DetailsArticleType;
use App\Repository\DetailsArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/listeArticle')]
class DetailsArticleController extends AbstractController
{
    #[Route('/{id}', name: 'app_liste_article', methods: ['GET'])]
    public function index(ListeCourse $listeCourse,DetailsArticleRepository $detailsArticleRepository): Response
    {
        $totalPrix = $detailsArticleRepository->totalPrix($listeCourse);
        $maxPrix = $detailsArticleRepository->maxPrix($listeCourse);
        $minPrix = $detailsArticleRepository->minPrix($listeCourse);
        $moyPrix = $detailsArticleRepository->moyPrix($listeCourse);
        return $this->render('details_article/index.html.twig', [
            'minPrix' => $minPrix,
            'maxPrix' => $maxPrix,
            'totalPrix' => $totalPrix,
            'moyPrix' => $moyPrix,
            'listeCourse' => $listeCourse
        ]);
    }

    #[Route('/add-article/{id}', name: 'app_details_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DetailsArticleRepository $detailsArticleRepository, ListeCourse $listeCourse): Response
    {
        $detailsArticle = new DetailsArticle();
        $form = $this->createForm(DetailsArticleType::class, $detailsArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detailsArticle->setListeCourse($listeCourse);
            $detailsArticle->setPrix($detailsArticle->getQuantite()*$detailsArticle->getArticle()->getPrixUnitaire());
            $detailsArticleRepository->save($detailsArticle, true);

            return $this->redirectToRoute('app_liste_article', ["id"=>$listeCourse->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('details_article/new.html.twig', [
            'details_article' => $detailsArticle,
            'form' => $form,
            'id'=> $listeCourse->getId()
        ]);
    }

    #[Route('/{id}', name: 'app_details_article_show', methods: ['GET'])]
    public function show(DetailsArticle $detailsArticle): Response
    {
        return $this->render('details_article/show.html.twig', [
            'details_article' => $detailsArticle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_details_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetailsArticle $detailsArticle, DetailsArticleRepository $detailsArticleRepository): Response
    {
        $form = $this->createForm(DetailsArticleType::class, $detailsArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detailsArticleRepository->save($detailsArticle, true);

            return $this->redirectToRoute('app_details_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('details_article/edit.html.twig', [
            'details_article' => $detailsArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_details_article_delete', methods: ['POST'])]
    public function delete(Request $request, DetailsArticle $detailsArticle, DetailsArticleRepository $detailsArticleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailsArticle->getId(), $request->request->get('_token'))) {
            $detailsArticleRepository->remove($detailsArticle, true);
        }

        return $this->redirectToRoute('app_liste_article', ["id"=>$detailsArticle->getListeCourse()->getId()], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/achete', name: 'app_details_article_achete', methods: ['POST'])]
    public function updateAchete(DetailsArticle $detailsArticle, DetailsArticleRepository $detailsArticleRepository): Response
    {
        $detailsArticle->setEstAchete(!$detailsArticle->isEstAchete());
        $detailsArticleRepository->save($detailsArticle, true);
        return $this->redirectToRoute('app_liste_article', ["id"=>$detailsArticle->getListeCourse()->getId()], Response::HTTP_SEE_OTHER);
    }
}
