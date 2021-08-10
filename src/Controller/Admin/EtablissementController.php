<?php

namespace App\Controller\Admin;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/etablissement")
 */
class EtablissementController extends AbstractController
{
    /**
     * @Route("/", name="etablissement-index", methods={"GET"})
     */
    public function index(EtablissementRepository $etablissementRepository): Response
    {
        return $this->render('Admin/Gestion/Gestion-Eta.html.twig', [
            'etablissements' => $etablissementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etablissement-new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etablissement = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etablissement);
            $entityManager->flush();

            return $this->redirectToRoute('etablissement-index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/etablissement/new.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="etablissement-show", methods={"GET"})
     */
    public function show(Etablissement $etablissement): Response
    {
        return $this->render('Admin/etablissement/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etablissement-edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etablissement $etablissement): Response
    {
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etablissement-index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/etablissement/edit.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="etablissement-delete", methods={"POST"})
     */
    public function delete(Request $request, Etablissement $etablissement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etablissement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etablissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etablissement-index', [], Response::HTTP_SEE_OTHER);
    }
}
