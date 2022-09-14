<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="app_default_", methods={"GET"})
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(MovieRepository $repository): Response
    {
        return $this->render('default/index.html.twig', [
            'movies' => $repository->findBy([], ['id' => 'DESC'], 6)
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
        }

        return $this->renderForm('default/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
