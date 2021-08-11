<?php

namespace App\Controller\Admin;

use App\Entity\Requete;
use App\Entity\User;
use App\Form\Requete1Type;
use App\Form\RequeteType;
use App\Repository\RequeteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/requete")
 */
class AdminRequeteController extends AbstractController
{
    /**
     * @Route("/", name="admin-requete-index", methods={"GET", "POST"})
     */
    public function index(RequeteRepository $requeteRepository): Response
    {
       
        return $this->renderForm('Admin/requete/index.html.twig', [
            'requetes' => $requeteRepository->last(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="admin-requete-new", methods={"GET","POST"})
     */
    public function new(Request $request, User $user): Response
    {
        $requete = new Requete();
        $form = $this->createForm(Requete1Type::class, $requete);
        $requete->setCreatedAt(new DateTime());
        $requete->setAuteur($user);
        $requete->setEtat('send');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requete);
            $entityManager->flush();

            return $this->redirectToRoute('requete-index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requete/new.html.twig', [
            'requete' => $requete,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin-requete-show", methods={"GET"})
     */
    public function show(Requete $requete): Response
    {
        return $this->render('requete/show.html.twig', [
            'requete' => $requete,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin-requete-edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Requete $requete): Response
    {
        $form = $this->createForm(Requete1Type::class, $requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('requete-index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requete/edit.html.twig', [
            'requete' => $requete,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin-requete-delete", methods={"POST"})
     */
    public function delete(Request $request, Requete $requete): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requete->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($requete);
            $entityManager->flush();
        }

        return $this->redirectToRoute('requete-index', [], Response::HTTP_SEE_OTHER);
    }

    
}
