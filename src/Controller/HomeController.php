<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'placeholder' => 'Please choose a country',
                'choice_label' => 'name',
                'query_builder' => fn(CountryRepository $countryRepository) => $countryRepository->createQueryBuilder('c')->orderBy('c.name','ASC')
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => 'Please choose a city',
                'disabled' => true,
                'query_builder' => fn(CityRepository $cityRepository) => $cityRepository->createQueryBuilder('c')->orderBy('c.name','ASC')
                
            ])
            ->add('message', TextareaType::class)
            ->getForm()
        ;


        return $this->render('home.index.html.twig',compact('form'));
    }
}
