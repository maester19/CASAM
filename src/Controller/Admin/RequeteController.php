<?php

namespace App\Controller\Admin;

use App\Entity\Requete;
use App\Form\RequeteType;
use App\Repository\RequeteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/requete")
 */
class RequeteController extends AbstractController
{
    /**
     * @Route("/", name="requete_index", methods={"GET"})
     */
    public function index(RequeteRepository $requeteRepository): Response
    {
        return $this->render('requete/index.html.twig', [
            'requetes' => $requeteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="requete_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requete = new Requete();
        $form = $this->createForm(RequeteType::class, $requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requete);
            $entityManager->flush();

            return $this->redirectToRoute('requete_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requete/new.html.twig', [
            'requete' => $requete,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="requete_show", methods={"GET"})
     */
    public function show(Requete $requete): Response
    {
        return $this->render('requete/show.html.twig', [
            'requete' => $requete,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="requete_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Requete $requete): Response
    {
        $form = $this->createForm(RequeteType::class, $requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('requete_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requete/edit.html.twig', [
            'requete' => $requete,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="requete_delete", methods={"POST"})
     */
    public function delete(Request $request, Requete $requete): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requete->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($requete);
            $entityManager->flush();
        }

        return $this->redirectToRoute('requete_index', [], Response::HTTP_SEE_OTHER);
    }
}
