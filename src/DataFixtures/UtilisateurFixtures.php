<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Entity\Professeur;
use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UtilisateurFixtures extends Fixture
{
    private $professeur = [];

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($faker->email);
            $utilisateur->setNom($faker->lastName);
            $utilisateur->setPrenom($faker->firstName);
            $utilisateur->setMdp(md5($faker->randomElement(array ('prof1','parent1','parent2','prof2'),1)));
            $utilisateur->setRoles($faker->randomElements(array ('ROLE_ADMIN','ROLE_PROF','ROLE_PARENT'), 1));
            $manager->persist($utilisateur);

            if (in_array("ROLE_PROF",$utilisateur->getRoles())){
                $prof = new Professeur();
                $prof->setUser($utilisateur);
                $manager->persist($prof);
                array_push($this->professeur,$prof);
            }
            if (in_array("ROLE_PARENT",$utilisateur->getRoles())){
                
                
               /* $parent = new Parent();
                $parent->setUser($utilisateur);
                $manager->persist($parent);
                */
            }

        }
        $this->loadPromotion($this->professeur,$manager);
        $manager->flush();
    }

    public function loadPromotion(array $professeur, ObjectManager $manager){
        $faker = Faker\Factory::create('fr_FR');
        $nom = array ('6EME 1 ','5EME 1','4 EME 1','3 EME 1','6 EME 2','3 EME 2','5 EME 2','4 EME 2', '3 EME 3','6 EME 3');
        for ($i = 0; $i < 10; $i++) {
            $promotion = new Promotion();
            $promotion->setNom($nom[$i]);
            $promotion->setProfesseur($faker->randomElement($professeur,1));
            $manager->persist($promotion);
        }

        $manager->flush();
    }
}
