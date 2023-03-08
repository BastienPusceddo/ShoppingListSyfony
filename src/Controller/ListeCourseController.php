<?php

namespace App\Controller;

use App\Entity\ListeCourse;
use App\Form\ListeCourseType;
use App\Repository\ListeCourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeCourseController extends AbstractController
{
    #[Route('/listecourse{id}', name: 'app_listeCourse', methods:['GET'])]
    public function index(ListeCourse $listeCourse): Response
    {
        return $this->render('liste_course/index.html.twig', [
            'listeCourse' => $listeCourse,
        ]);
    }

    #[Route('/listecourse{id}/edit', name: 'app_listeCourse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListeCourse $listeCourse, ListeCourseRepository $listeCourseRepository): Response
    {
        $form = $this->createForm(ListeCourseType::class, $listeCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listeCourseRepository->save($listeCourse, true);

            return $this->redirectToRoute('app_listeCourse', ["id"=>$listeCourse->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('liste_course/edit.html.twig', [
            'listeCourse' => $listeCourse,
            'form' => $form,
        ]);
    }
}
