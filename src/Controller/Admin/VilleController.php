<?php

namespace App\Controller\Admin;

use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/ville")
 */
class VilleController extends AbstractController
{
    /**
     * @Route("/", name="ville-index", methods={"GET"})
     */
    public function index(VilleRepository $villeRepository): Response
    {
        return $this->render('Admin/Gestion/Gestion-V.html.twig', [
            'villes' => $villeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ville-new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->all();
            $ville->setNom($data['nom'])
                ->setPays($data['pays']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ville);
            $entityManager->flush();

            return $this->redirectToRoute('ville-index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/ville/new.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ville-show", methods={"GET"})
     */
    public function show(Ville $ville): Response
    {
        return $this->render('Admin/ville/show.html.twig', [
            'ville' => $ville,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ville-edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ville $ville): Response
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->all();
            $ville->setNom($data['nom'])
                ->setPays($data['pays']);
                
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ville-index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/ville/edit.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ville-delete", methods={"POST"})
     */
    public function delete(Request $request, Ville $ville): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ville);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ville-index', [], Response::HTTP_SEE_OTHER);
    }
}
