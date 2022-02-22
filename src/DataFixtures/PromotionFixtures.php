<?php

namespace App\DataFixtures;

use App\Repository\ProfesseurRepository;
use App\Entity\Promotion;
use App\Entity\Professeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PromotionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       /* //$professeurRepository=new ProfesseurRepository();
        $professeurRepository=$this->getDoctrine();
        $profs = $professeurRepository->findAll();
        dump($profs);
        die();
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $promotion = new Promotion();
            $promotion->setNom(($faker->randomElement(array ('6EME 1 ','5EME 1','4 EME 1','3 EME 1','6 EME 2','3 EME 2','5 EME 2'),1)));
            $promotion->setProfesseur($faker->randomElement($profs,1));
            $manager->persist($promotion);
        }

        $manager->flush();*/
    }
}
