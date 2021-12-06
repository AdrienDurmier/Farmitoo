<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Brand;

class BrandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $brand1 = new Brand();
        $brand1->setTitle('Farmitoo');
        $brand1->setVat($this->getReference('fra-taux-normal'));
        $manager->persist($brand1);
        $this->addReference('brand-farmitoo', $brand1);

        $brand2 = new Brand();
        $brand2->setTitle('Gallagher');
        $brand2->setVat($this->getReference('fra-taux-reduit'));
        $manager->persist($brand2);
        $this->addReference('brand-gallagher', $brand2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            VatFixtures::class
        );
    }
}
