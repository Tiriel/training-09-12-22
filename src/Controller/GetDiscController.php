<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/disc", name="app_disc")
 */
class GetDiscController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        return $this->render('');
    }
}