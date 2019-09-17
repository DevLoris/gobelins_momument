<?php

namespace App\Controller;

use App\Entity\Monument;
use App\Entity\Note;
use App\Form\MonumentType;
use App\Repository\MonumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/monument")
 */
class MonumentController extends AbstractController
{
    /**
     * @Route("/", name="monument_index", methods={"GET"})
     */
    public function index(MonumentRepository $monumentRepository): Response
    {
        return $this->render('monument/index.html.twig', [
            'monuments' => $monumentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="monument_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $monument = new Monument();
        $form = $this->createForm(MonumentType::class, $monument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($monument);
            $entityManager->flush();

            return $this->redirectToRoute('monument_index');
        }

        return $this->render('monument/new.html.twig', [
            'monument' => $monument,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="monument_show", methods={"GET"})
     */
    public function show(Monument $monument): Response
    {
        return $this->render('monument/show.html.twig', [
            'monument' => $monument,
        ]);
    }


    /**
     * @Route("/rate/{id}", name="monument_rate", methods={"POST"})
     */
    public function rating(Request $request, Monument $monument): Response
    {
        $all = json_decode($request->getContent(), true);
        if($all['rating'] && in_array($all['rating'], ["1", "2", "3", "4", "5"])) {
            $rate = new Note();
            $rate->setMonument($monument);
            $rate->setRating($all['rating']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rate);
            $entityManager->flush();

            return $this->json(['success' => true]);
        }
    }

    /**
     * @Route("/update/{id}", name="monument_onfly", methods={"POST"})
     */
    public function onFlyUpdate(Request $request, Monument $monument): Response
    {
        $all = json_decode($request->getContent(), true);
        switch ($all['field']){
            case "description":
                $monument->setDescription($all['value']);
                break;
            case "name":
                $monument->setName($all['value']);
                break;
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['success' => true]);
    }

    /**
     * @Route("/{id}/edit", name="monument_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Monument $monument): Response
    {
        $form = $this->createForm(MonumentType::class, $monument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('monument_index');
        }

        return $this->render('monument/edit.html.twig', [
            'monument' => $monument,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="monument_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Monument $monument): Response
    {
        if ($this->isCsrfTokenValid('delete'.$monument->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($monument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('monument_index');
    }
}
