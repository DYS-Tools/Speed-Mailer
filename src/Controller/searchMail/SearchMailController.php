<?php

namespace App\Controller\searchMail;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SearchMailController extends AbstractController
{
    /**
     * @Route("/search/mail", name="searchMail")
     */
    public function index()
    {

        return $this->render('searchMail/index.html.twig', [
            'controller_name' => 'SearchMailController',
        ]);
    }
}