<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
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
    public function index(BookRepository $repository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookRepository $repository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($book);
            $book->setAddedBy($this->getUser());
            $repository->add($book, true);

            return $this->redirectToRoute('app_book_index');
        }

        return $this->renderForm('book/new.html.twig', [
            'book_form' => $form,
        ]);
    }
}
