<?php

namespace App\DataFixtures;

use App\Service\Slugify;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        [
            'title' => 'Episode 1',
            'synopsis' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'season' => 'season_0',
            'number' => 1
        ],

        [
            'title' => 'Episode 2',
            'synopsis' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'season' => 'season_0',
            'number' => 1
        ],

        [
            'title' => 'Episode 3',
            'synopsis' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'season' => 'season_0',
            'number' => 1
        ],

        [
            'title' => 'Episode 4',
            'synopsis' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'season' => 'season_0',
            'number' => 1
        ],

        [
            'title' => 'Episode 5',
            'synopsis' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'season' => 'season_0',
            'number' => 1
        ],
    ];

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $key => $show) {
            $episode = new Episode();

            $episode->setTitle($show['title']);
            $episode->setSynopsis($show['synopsis']);
            $episode->setNumber($show['number']);
            $episode->setSeason($this->getReference($show['season']));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $manager->persist($episode);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SeasonFixtures::class
        ];
    }
}
