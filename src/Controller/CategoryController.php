<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * Show all rows from Category's entity
     * 
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render(
            'category/index.html.twig',
            ['categories' => $categories]
        );
    }

    /**
     * Getting a category by id
     *
     * @Route("/{categoryName}", name ="show")
     * @return Response
     */
    public function show(string $categoryName): Response
    {

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(['name'=> $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'The product does not exist'
            );
        }

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category],['id'=> 'DESC'], $limit= 3 );

            if (!$programs) {
                throw $this->createNotFoundException(
                    'The product does not exist'
                );
            }

        return $this->render('/category/show.html.twig', [
            'name' => $categoryName,
            'programs' => $programs,
        ]);
    }
}