<?php

namespace App\DataFixtures;

use App\Entity\Parents;
use App\Entity\ServerSetting;
use App\Entity\Utilisateur;


use App\Entity\Professeur;
use App\Entity\Promotion;
use App\Entity\Eleve;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UtilisateurFixtures extends Fixture
{

    private $professeur = [];
    private  $parents = [];
    private  $promotions = [];


    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $utilisateur = new Utilisateur();

            // Compte PROFESSEUR
            if($i==0){
                $utilisateur->setEmail("prof1@mail.test");
                $utilisateur->setNom("Doum Akono ");
                $utilisateur->setPrenom("Rudolph");
                $utilisateur->setMdp(md5("prof1"));
                $utilisateur->setRoles(array ('ROLE_PROF'));
                $manager->persist($utilisateur);
            }elseif ($i== 1){
                $utilisateur->setEmail("parent1@mail.test");
                $utilisateur->setNom("Yvana");
                $utilisateur->setPrenom("Nawel");
                $utilisateur->setMdp(md5("parent1"));
                $utilisateur->setRoles(array ('ROLE_PARENT'));
                $manager->persist($utilisateur);
            }else{
                $utilisateur->setEmail($faker->email);
                $utilisateur->setNom($faker->lastName);
                $utilisateur->setPrenom($faker->firstName);
                $utilisateur->setMdp(md5($faker->randomElement(array ('prof1','parent1','parent2','prof2'),1)));
                $utilisateur->setRoles($faker->randomElements(array ('ROLE_PROF','ROLE_PARENT'), 1));
                $manager->persist($utilisateur);
            }

            if (in_array("ROLE_PROF",$utilisateur->getRoles())){
                $prof = new Professeur();
                $prof->setUser($utilisateur);
                $manager->persist($prof);
                array_push($this->professeur,$prof);
            }
            if (in_array("ROLE_PARENT",$utilisateur->getRoles())){
                $parent = new Parents();
                $parent->setUser($utilisateur);
                $manager->persist($parent);

                array_push($this->parents,$parent);

            }

        }
        $this->loadPromotion($this->professeur,$manager);
        $this->loadEleve($this->parents, $this->promotions,$manager);

        $server = new ServerSetting();
        $server->setName('videoServer');
        $server->setValue('https://mydemoapps.azurewebsites.net/');
        $manager->persist($server);
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

            array_push($this->promotions, $promotion);

        }

        $manager->flush();
    }

    public function loadEleve(array $parents, array  $promotions, ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 200; $i++) {
            $eleve = new Eleve();
            $eleve->setMatricule($faker->iban(null,'',10));
            $eleve->setNom($faker->lastName);
            $eleve->setPrenom($faker->firstName);
            $eleve->setParents($faker->randomElement($this->parents));
            $eleve->setPromotion($faker->randomElement($this->promotions));
            $manager->persist($eleve);

            $manager->flush();
        }
    }
}
