<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Promotion;

class PromotionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $promotion1 = new Promotion();
        $promotion1->setMinAmount(50000);
        $promotion1->setReduction(8);
        $promotion1->setFreeDelivery(false);
        $manager->persist($promotion1);

        $promotion1 = new Promotion();
        $promotion1->setMinAmount(100000);
        $promotion1->setReduction(0);
        $promotion1->setFreeDelivery(true);
        $manager->persist($promotion1);

        $manager->flush();
    }

}
