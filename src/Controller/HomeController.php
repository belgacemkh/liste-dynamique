<?php

namespace App\Controller;

use App\Form\TicketFormType;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, CountryRepository $country): Response
    {
        $form = $this->createForm(TicketFormType::class,['country' => $country->find(3)]);
          
      
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd('toto');
        }

        return $this->render('home.index.html.twig', compact('form'));
    }
}
