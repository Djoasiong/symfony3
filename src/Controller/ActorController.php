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
}