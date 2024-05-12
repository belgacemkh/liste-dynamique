<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Country;
use App\Form\TicketFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $countryRepository = $em->getRepository(Country::class);
        $france = $countryRepository->find(1); 
        
        $ticket = new Ticket;
        $ticket->setCountry($france);
        
        $form = $this->createForm(TicketFormType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ticket);
            $em->flush();

            $this->addFlash('success', 'Thanks for your message. We\'ll get back to you shortly.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home.html.twig', compact('form'));
    }
}