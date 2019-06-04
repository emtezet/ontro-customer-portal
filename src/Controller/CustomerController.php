<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class CustomerController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('Customer/details.html.twig', [
            'controller_name' => 'CustomerController',
            'user' => $user
        ]);
    }
}
