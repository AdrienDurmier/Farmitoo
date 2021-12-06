<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Vat;

class VatFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tax1 = new Vat();
        $tax1->setTitle('20%');
        $tax1->setRate(20.00);
        $tax1->setCountry($this->getReference('country-france'));
        $manager->persist($tax1);
        $this->addReference('fra-taux-normal', $tax1);

        $tax2 = new Vat();
        $tax2->setTitle('5%');
        $tax2->setRate(5.00);
        $tax2->setCountry($this->getReference('country-france'));
        $manager->persist($tax2);
        $this->addReference('fra-taux-reduit', $tax2);

        $tax3 = new Vat();
        $tax3->setTitle('20%');
        $tax3->setRate(20.00);
        $tax3->setCountry($this->getReference('country-espagne'));
        $manager->persist($tax3);
        $this->addReference('esp-taux-normal', $tax3);

        $tax4 = new Vat();
        $tax4->setTitle('10%');
        $tax4->setRate(10.00);
        $tax4->setCountry($this->getReference('country-espagne'));
        $manager->persist($tax4);
        $this->addReference('esp-taux-reduit', $tax4);

        $tax5 = new Vat();
        $tax5->setTitle('20%');
        $tax5->setRate(22.00);
        $tax5->setCountry($this->getReference('country-italie'));
        $manager->persist($tax5);
        $this->addReference('ita-taux-normal', $tax5);

        $tax6 = new Vat();
        $tax6->setTitle('10%');
        $tax6->setRate(10.00);
        $tax6->setCountry($this->getReference('country-italie'));
        $manager->persist($tax6);
        $this->addReference('ita-taux-reduit', $tax6);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CountryFixtures::class
        );
    }
}
