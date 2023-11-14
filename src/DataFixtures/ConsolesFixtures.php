<?php

namespace App\DataFixtures;

use App\Entity\Console;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ConsolesFixtures extends Fixture
{

    private $counter = 1;

    public function __construct(
        private SluggerInterface $sluggerInterface,
    ) {}

    public function load(ObjectManager $manager): void
    {
      $consoles = [
        "Atari 2600",
        "Nintendo",
        "Master System",
        "Super Nintendo",
        "Mega Drive",
        "PlayStation",
        "Saturn",
        "Nintendo 64",
        "PlayStation 2",
        "Xbox",
        "GameCube",
        "PlayStation Portable",
        "Xbox 360",
        "DS",
        "PlayStation 3",
        "Wii",
        "3DS",
        "PlayStation Vita",
        "Xbox One",
        "PlayStation 4",
        "Switch",
        "Dreamcast",
        "Neo Geo",
        "Commodore 64",
        "Amiga"
    ];


        foreach ($consoles as $consoleName){

          $console = new Console();
          $console->setName($consoleName);
          $console->setSlug($this->sluggerInterface->slug($console->getName())->lower());

          $this->addReference('con-'.$this->counter, $console);
          $this->counter++;

          $manager->persist($console);
        }

        $manager->flush();
    }
}
