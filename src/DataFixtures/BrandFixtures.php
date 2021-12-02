<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Brand;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $brand1 = new Brand();
        $brand1->setTitle('Farmitoo');
        $manager->persist($brand1);
        $this->addReference('brand-farmitoo', $brand1);

        $brand2 = new Brand();
        $brand2->setTitle('Gallagher');
        $manager->persist($brand2);
        $this->addReference('brand-gallagher', $brand2);

        $manager->flush();
    }
}
