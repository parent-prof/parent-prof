<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UtilisateurFixtures extends Fixture
{
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
        }

        $manager->flush();
    }
}
