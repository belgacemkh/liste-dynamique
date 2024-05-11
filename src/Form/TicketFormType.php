<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TicketFormType extends AbstractType
{

    public function __construct(private CityRepository $cityRepository){}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'constraints' => new NotBlank(['message' => 'Please enter your name'])
        ])
        ->add('country', EntityType::class, [
            'class' => Country::class,
            'placeholder' => 'Please choose a country',
            'choice_label' => 'name',
            'query_builder' => fn (CountryRepository $countryRepository) => $countryRepository->findAllOrderByNameQueryBuilder(),
            'constraints' => new NotBlank(['message' => 'Please choose a country'])
        ])
        ->add('message', TextareaType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Seems like your issues has been resolved :)']),
                new Length(['min' => 5]),
            ]
        ])
        ->addEventListener(FormEvents:: PRE_SET_DATA, function(FormEvent $event){

            $country = $event->getData()['country'] ?? null;

            $cities = $country === null ? [] : $this->cityRepository->findByCountry($country, ['name' => 'ASC']);
       
            $event->getForm()->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'choices' => $cities,
                'disabled' => $country === null,
                'placeholder' => 'Please choose a city',
                'constraints' => new NotBlank(['message' => 'Please choose a city'])
            ]);


        })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
