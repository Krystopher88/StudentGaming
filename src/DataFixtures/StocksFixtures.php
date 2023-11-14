<?php

namespace App\DataFixtures;

use App\Entity\Stocks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class StocksFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create('fr_FR');

        for ($stk = 0; $stk <=50; $stk++){

          $stock = new Stocks();
          $stock->setQuantity($faker->numberBetween(0, 100));
          $stock->setPrice($faker->randomFloat(1, 10, 100));

          $console = $this->getReference('con-' . rand(1, 25));
          $stock->setConsole($console);

          $games = $this->getReference('game-' . rand(1, 50));
          $stock->setGame($games);

          $manager->persist($stock);
        }

        $manager->flush();
    }
    
    public function getDependencies(): array
    {
        return [
            GamesFixtures::class, 
        ];
    }
}
