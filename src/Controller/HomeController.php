<?php

namespace App\Controller;

use App\Repository\MonumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(MonumentRepository $monumentRepository): Response
    {
        return $this->render('index.html.twig', [
            'last_monuments' => $monumentRepository->findLasts(3),
            'monuments' => $monumentRepository->findRandoms(3),
        ]);
    }
}
