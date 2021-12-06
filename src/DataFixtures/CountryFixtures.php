<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Country;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fra = new Country();
        $fra->setTitle('France');
        $fra->setIso3166Alpha3('FRA');
        $manager->persist($fra);
        $this->addReference('country-france', $fra);

        $esp = new Country();
        $esp->setTitle('Espagne');
        $esp->setIso3166Alpha3('ESP');
        $manager->persist($esp);
        $this->addReference('country-espagne', $esp);

        $ita = new Country();
        $ita->setTitle('Italie');
        $ita->setIso3166Alpha3('ITA');
        $manager->persist($ita);
        $this->addReference('country-italie', $ita);

        $manager->flush();
    }
}
