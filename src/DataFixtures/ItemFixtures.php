<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Item;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $item1 = new Item();
        $item1->setProduct($this->getReference('product-cuve_a_gazoil'));
        $item1->setQuantity(1);
        $manager->persist($item1);
        $this->addReference('item1', $item1);

        $item2 = new Item();
        $item2->setProduct($this->getReference('product-nettoyant_pour_cuve'));
        $item2->setQuantity(3);
        $manager->persist($item2);
        $this->addReference('item2', $item2);

        $item3 = new Item();
        $item3->setProduct($this->getReference('product-piquet_de_cloture'));
        $item3->setQuantity(5);
        $manager->persist($item3);
        $this->addReference('item3', $item3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProductFixtures::class
        );
    }
}
