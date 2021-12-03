<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product1 = new Product();
        $product1->setTitle('Cuve à gasoil');
        $product1->setPrice(25000);
        $product1->setBrand($this->getReference('brand-farmitoo'));
        $manager->persist($product1);
        $this->addReference('product-cuve_a_gazoil', $product1);

        $product2 = new Product();
        $product2->setTitle('Nettoyant pour cuve');
        $product2->setPrice(5000);
        $product2->setBrand($this->getReference('brand-farmitoo'));
        $manager->persist($product2);
        $this->addReference('product-nettoyant_pour_cuve', $product2);

        $product3 = new Product();
        $product3->setTitle('Piquet de clôture');
        $product3->setPrice(1000);
        $product3->setBrand($this->getReference('brand-gallagher'));
        $manager->persist($product3);
        $this->addReference('product-piquet_de_cloture', $product3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            BrandFixtures::class
        );
    }
}
