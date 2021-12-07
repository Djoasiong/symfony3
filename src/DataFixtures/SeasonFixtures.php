<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        [
            'program' => 'program_1',
            'description' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'year' => 2015,
            'number' => 1,
        ],
        [
            'program' => 'program_1',
            'description' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'year' => 2016,
            'number' => 2,
        ],
        [
            'program' => 'program_1',
            'description' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'year' => 2017,
            'number' => 3,
        ],
        [
            'program' => 'program_1',
            'description' => 'Le Royaume des Sept Couronnes3, dont la capitale est Port-Réal, est constitué de sept provinces régies par des « maisons »4 dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros.',
            'year' => 2018,
            'number' => 4,
        ],

        [
            'program' => 'program_1',
            'description' => 'Les "observateurs", apparemment pacifiques, ont pris le contrôle de l\'univers en 2015. Seul le plan mis en place par Walter et l\’observateur Septembre pourra les arrêter.',
            'year' => 2012,
            'number' => 5,
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASONS as $key => $show) {
            $season = new Season();

            $season->setprogram($this->getReference($show['program']));
            $season->setDescription($show['description']);
            $season->setYear($show['year']);
            $season->setNumber($show['number']);
            $manager->persist($season);
            $this->addReference('season_' . $key, $season);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class
        ];
    }
}
