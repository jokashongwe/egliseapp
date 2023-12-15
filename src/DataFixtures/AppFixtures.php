<?php

namespace App\DataFixtures;

use App\Entity\TypeCulte;
use App\Entity\TypeOffrande;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $typeOffrande = new TypeOffrande();
        $typeOffrande->setLibelle("Dîme");
        $typeOffrande->setCode("DIME");
        $manager->persist($typeOffrande);

        $typeOffrande = new TypeOffrande();
        $typeOffrande->setLibelle("Offrande Ordinaire");
        $typeOffrande->setCode("OFFRANDE-ORDINAIRE");
        $manager->persist($typeOffrande);

        $typeOffrande = new TypeOffrande();
        $typeOffrande->setLibelle("Offrande Spéciale");
        $typeOffrande->setCode("OFFRANDE-SPECIALE");
        $manager->persist($typeOffrande);

        $typeCulte = new TypeCulte();
        $typeCulte->setLibelle("Hebdomadaire");
        $manager->persist($typeCulte);

        $typeCulte = new TypeCulte();
        $typeCulte->setLibelle("Séminaire");
        $manager->persist($typeCulte);

        $typeCulte = new TypeCulte();
        $typeCulte->setLibelle("Jeunesse");
        $manager->persist($typeCulte);
        
        $typeCulte = new TypeCulte();
        $typeCulte->setLibelle("ECODIM");
        $manager->persist($typeCulte);
        $manager->flush();
    }
}
