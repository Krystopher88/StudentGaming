<?php

namespace App\DataFixtures;

use App\Entity\Pegi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PegiFixtures extends Fixture
{

  private $counter = 1;

    public function load(ObjectManager $manager): void
    {
      $pegis = [3, 7, 12, 16, 18];


        foreach ($pegis as $pegiValue){
          $pegi = new Pegi();
          $pegi->setAge($pegiValue);

          $manager->persist($pegi);

          $this->addReference('age-'.$this->counter, $pegi);
          $this->counter++;
        }

        $manager->flush();
    }

    
}
