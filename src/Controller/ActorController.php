<?php 

// src/Controller/ActorController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActorRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Program;
use App\Entity\Actor;
use App\Form\ActorType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * Show all rows from Actor's entity
     * 
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        return $this->render(
            'actor/index.html.twig',
            ['actors' => $actors]);
    }
    /**
     *
     * @Route("/{id<^[0-9]+$>}", name="show")
     * @return Response
     */
    public function show(Actor $actor): Response
    {
        $programs= $actor->getPrograms();
    
        if ($programs->isEmpty()) {
            throw $this->createNotFoundException(
                'Not actor found in this program'
            );
        }
    
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/new", name="actor_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actor);
            $entityManager->flush();

            $this->addFlash('success', "L'acteur a bien été ajouté");

            return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actor/new.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Actor $actor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'L\'acteur a bien été modifié');

            return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Actor $actor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $actor->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actor);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'L\'acteur a bien été supprimé');

        return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
    }
}