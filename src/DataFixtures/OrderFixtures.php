<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $order = new Order();
        $order->addItem($this->getReference('item1'));
        $order->addItem($this->getReference('item2'));
        $order->addItem($this->getReference('item3'));
        $manager->persist($order);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ItemFixtures::class
        );
    }
}
