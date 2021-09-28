<?php

namespace App\DataFixtures;

use App\Entity\Cotisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $cotisation = new Cotisation();
            $cotisation->setYear(rand(2000, 2021));
            $cotisation->setMonth(rand(01, 12));
            $cotisation->setPmssAmount(rand(290000, 350000) / 100);
            $cotisation->setSmicAmount(rand(700, 1800) / 100);
            $manager->persist($cotisation);
        }

        $manager->flush();
    }
}
