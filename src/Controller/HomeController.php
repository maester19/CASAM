<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Form;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/actualiter", name="actualiter")
     */
    public function actu(): Response
    {
        return $this->render('home/actualite.html.twig');
    }

    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile(User $user, Request $request): Response
    {
        if($request->isMethod('POST')){
            $data = $request->request->all();
            $user->setNoteVille($data['townNotation']);
            $user->setNoteEta($data['schoolNotation']);

            $entityManager = $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('profile/user.html.twig', [
            "user" => $user,
        ]);
    }

    
}
