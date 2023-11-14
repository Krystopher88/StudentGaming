<?php

namespace App\DataFixtures;

use App\Entity\Games;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class GamesFixtures extends Fixture implements DependentFixtureInterface
{

    private $counter = 1;

    public function __construct(
        private SluggerInterface $sluggerInterface) {}

    public function load(ObjectManager $manager): void
    {

        $gameTitle = [
            "The Legend of Zelda: Ocarina of Time",
            "Super Mario 64",
            "Final Fantasy VII",
            "Resident Evil 2",
            "Metal Gear Solid",
            "Castlevania: Symphony of the Night",
            "Chrono Trigger",
            "Silent Hill",
            "Half-Life",
            "Diablo II",
            "Grand Theft Auto III",
            "Halo: Combat Evolved",
            "Warcraft III: Reign of Chaos",
            "The Elder Scrolls III: Morrowind",
            "Max Payne",
            "Kingdom Hearts",
            "Devil May Cry",
            "Star Wars: Knights of the Old Republic",
            "Fable",
            "Jak and Daxter: The Precursor Legacy",
            "Sly Cooper and the Thievius Raccoonus",
            "Prince of Persia: The Sands of Time",
            "Beyond Good & Evil",
            "Viewtiful Joe",
            "Far Cry",
            "World of Warcraft",
            "Half-Life 2",
            "Halo 2",
            "Metal Gear Solid 3: Snake Eater",
            "Grand Theft Auto: San Andreas",
            "Resident Evil 4",
            "Shadow of the Colossus",
            "The Elder Scrolls IV: Oblivion",
            "Gears of War",
            "Bioshock",
            "Assassin's Creed",
            "Mass Effect",
            "Uncharted: Drake's Fortune",
            "The Witcher",
            "Fallout 3",
            "Dead Space",
            "Red Dead Redemption",
            "Dark Souls",
            "The Legend of Zelda: Skyward Sword",
            "The Last of Us",
            "Bioshock Infinite",
            "Grand Theft Auto V",
            "The Witcher 3: Wild Hunt",
            "Bloodborne",
            "Dark Souls III",
        ];

        $faker = \Faker\Factory::create('fr_FR');

        foreach ($gameTitle as $title) {
            $games = new Games();
            $games->setTitle($title);
            $games->setDescription($faker->text(350));
            $games->setNote($faker->numberBetween(0, 10));
            $games->setReleaseDate($faker->dateTimeBetween('-20 years', 'now'));
            $games->setSlug($this->sluggerInterface->slug($games->getTitle())->lower());
            $multiplayer = $faker->boolean;
            $games->setMultiplayer($multiplayer);

            $category = $this->getReference('cat-' . rand(1, 24));
            $games->addCategory($category);

            $pegi = $this->getReference('age-' . rand(1, 5));
            $games->setPegi($pegi);

            $this->addReference('game-' . $this->counter, $games);
            $this->counter++;

            $manager->persist($games);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PegiFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
