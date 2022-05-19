<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comptes;

class ComptesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i =1; $i <=10; $i++){
            $comptes = new Comptes();
            $comptes-> setTitle("Catégorie du compte n°$i")
                ->setContent("<p> Contenu du compte n°$i</p>")
                ->setImage("http://placehold.it/350x150")
                ->setCreatedAt(new \DateTime());
            
            $manager->persist($comptes);
        }
        $manager->flush();
    }
}
