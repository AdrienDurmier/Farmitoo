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
        $brand1->setTax($this->getReference('tax-20'));
        $manager->persist($brand1);
        $this->addReference('brand-farmitoo', $brand1);

        $brand2 = new Brand();
        $brand2->setTitle('Gallagher');
        $brand2->setTax($this->getReference('tax-05'));
        $manager->persist($brand2);
        $this->addReference('brand-gallagher', $brand2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TaxFixtures::class
        );
    }
}
