<?php

namespace App\Controller\Admin;

use App\Repository\EtablissementRepository;
use App\Repository\RequeteRepository;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(EtablissementRepository $etablissementRepository, UserRepository $userRepository,
                            VilleRepository $villeRepository, RequeteRepository $requeteRepository): Response
    {
        return $this->render('Admin/index.html.twig', [
            "etablissements" => sizeof($etablissementRepository->findAll()),
            "etudiants" => sizeof($userRepository->findAll()),
            "villes" => sizeof($villeRepository->findAll()),
            "requetes" => sizeof($requeteRepository->findBy(array("etat" => "running"))) + sizeof($requeteRepository->findBy(array("etat" => "send"))),
        ]);
    }

}
