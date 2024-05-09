<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //France
        $france = new Country;
        $france->setName('France');

        $paris = new City;
        $paris->setName('Paris');
        $paris->setCountry($france);

        $marseille = new City;
        $marseille->setName('Marseille');
        $marseille->setCountry($france);

        $lyon = new City;
        $lyon->setName('Lyon');
        $lyon->setCountry($france);

        $manager->persist($france);
        $manager->persist($paris);
        $manager->persist($marseille);
        $manager->persist($lyon);

        //Canada
        $canada = new Country;
        $canada->setName('Canada');

        $quebec = new City;
        $quebec->setName('Québec');
        $quebec->setCountry($canada);

        $montreal = new City;
        $montreal->setName('Montreal');
        $montreal->setCountry($canada);

        $troisRivieres= new City;
        $troisRivieres->setName('Trois-Rivières');
        $troisRivieres->setCountry($canada);

        $manager->persist($canada);
        $manager->persist($quebec);
        $manager->persist($montreal);
        $manager->persist($troisRivieres);

        //Tunisia
        $tunisia = new Country;
        $tunisia->setName('Tunisia');

        $tunis = new City;
        $tunis->setName('Tunis');
        $tunis->setCountry($tunisia);

        $sousse = new City;
        $sousse->setName('Sousse');
        $sousse->setCountry($tunisia);

        $sfax= new City;
        $sfax->setName('Sfax');
        $sfax->setCountry($tunisia);

        $manager->persist($tunisia);
        $manager->persist($tunis);
        $manager->persist($sousse);
        $manager->persist($sfax);



        $manager->flush();
    }
}
