<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{

    private $counter = 1;

    public function __construct(
      private SluggerInterface $sluggerInterface)
    {}

    public function load(ObjectManager $manager): void
    {
      $categorys = [
        'Action',
        'Aventure',
        'RPG (Jeu de rôle)',
        'Stratégie',
        'Simulation',
        'Sport',
        'Course',
        'Puzzle',
        'Horreur',
        'Science-fiction',
        'Fantasy',
        'Plateforme',
        'FPS (First-Person Shooter)',
        'TPS (Third-Person Shooter)',
        'Combat',
        'Musical',
        'Party',
        'Indépendant',
        'Survie',
        'Open World',
        'Rogue-like',
        'Jeux de cartes',
        'Jeux de société',
        'Coopératif',
        'Multijoueur en ligne',
        'Monde ouvert',
        'Exploration',
        'Gestion',
        'Simulation de vie',
    ];

        foreach ($categorys as $categoryName){

          $category = new Category();
          $category->setName($categoryName);
          $category->setSlug($this->sluggerInterface->slug($category->getName())->lower());
          $manager->persist($category);

          $this->addReference('cat-'.$this->counter, $category);
          $this->counter++;
        }

        $manager->flush();
    }
    
}
