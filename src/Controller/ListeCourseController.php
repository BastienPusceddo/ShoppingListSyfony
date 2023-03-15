<?php

namespace App\Controller;

use App\Entity\ListeCourse;
use App\Form\ListeCourse1Type;
use App\Repository\ListeCourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/listeCourse')]
class ListeCourseController extends AbstractController
{

    #[Route('/new', name: 'app_liste_course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ListeCourseRepository $listeCourseRepository): Response
    {
        $user = $this->getUser();
        $listeCourse = new ListeCourse();
        $form = $this->createForm(ListeCourse1Type::class, $listeCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listeCourse->setUtilisateur($user);
            $listeCourseRepository->save($listeCourse, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('liste_course/new.html.twig', [
            'liste_course' => $listeCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_course_show', methods: ['GET'])]
    public function show(ListeCourse $listeCourse): Response
    {
        return $this->render('liste_course/show.html.twig', [
            'liste_course' => $listeCourse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_liste_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListeCourse $listeCourse, ListeCourseRepository $listeCourseRepository): Response
    {
        $form = $this->createForm(ListeCourse1Type::class, $listeCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $listeCourseRepository->save($listeCourse, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('liste_course/edit.html.twig', [
            'liste_course' => $listeCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_course_delete', methods: ['POST'])]
    public function delete(Request $request, ListeCourse $listeCourse, ListeCourseRepository $listeCourseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listeCourse->getId(), $request->request->get('_token'))) {
            $listeCourseRepository->remove($listeCourse, true);
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
