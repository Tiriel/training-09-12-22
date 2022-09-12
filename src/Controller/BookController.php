<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book", name="app_book_")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/{id<\d+>?1}", name="details", methods={"GET", "POST"})
     */
    public function details(Request $request, int $id = 1): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => $id,
        ]);
    }

    /**
     * @Route("/", name="index", priority="1")
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
}
