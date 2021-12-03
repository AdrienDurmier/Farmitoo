<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tax;

class TaxFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tax1 = new Tax();
        $tax1->setTitle('20%');
        $tax1->setRate(20.00);
        $manager->persist($tax1);
        $this->addReference('tax-20', $tax1);

        $tax2 = new Tax();
        $tax2->setTitle('5%');
        $tax2->setRate(5.00);
        $manager->persist($tax2);
        $this->addReference('tax-05', $tax2);

        $manager->flush();
    }
}
