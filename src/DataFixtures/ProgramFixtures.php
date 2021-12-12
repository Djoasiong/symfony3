<?php

namespace App\DataFixtures;

use App\Service\Slugify;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    const PROGRAMS = [
        [
            'title' => 'Walking dead',
            'summary' => 'Des zombies envahissent la terre',
            'category' => 'category_5',
            'actor' => ['actor_1', 'actor_2', 'actor_3', 'actor_5'],
            'poster' => 'https://static.wikia.nocookie.net/walking-dead/images/d/d2/PosterSaison1.jpg/revision/latest/top-crop/width/360/height/450?cb=20140729112649&path-prefix=fr',
        ],

        [
            'title' => 'Breaking bad',
            'summary' => "Walter « Walt » White est professeur de chimie dans un lycée, et vit avec son fils handicapé moteur et sa femme enceinte à Albuquerque, au Nouveau-Mexique. Le lendemain de son cinquantième anniversaire, on lui diagnostique un cancer du poumon en phase terminale avec une espérance de vie estimée à deux ans. Tout s'effondre pour lui ! Il décide alors de mettre en place un laboratoire et un trafic de méthamphétamine pour assurer un avenir financier confortable à sa famille après sa mort, en s'associant à Jesse Pinkman, un de ses anciens élèves devenu petit trafiquant.",
            'category' => 'category_0',
            'actor' => ['actor_2', 'actor_3'],
            'poster' => 'http://www.asud.org/wp-content/uploads/2014/01/Breaking-bad.jpg'
        ],

        [
            'title' => 'Grey\'s Anatomy',
            'summary' => "Cette série met en scène une équipe médicale d'un hôpital fictif de Seattle : le Seattle Grace Hospital (puis Seattle Grace - Mercy West Hospital, lors de la saison 6 et enfin, Grey Sloan Memorial Hospital, dès la saison 9). Le titre fait référence à Meredith Grey, interne, résidente, titulaire puis chef du service de chirurgie générale, qui a un lien plus ou moins direct avec tous les autres personnages principaux.",
            'category' => 'category_1',
            'actor' => ['actor_1', 'actor_4'],
            'poster' => 'https://static1.purepeople.com/articles/4/38/32/64/@/5524397-affiche-officielle-de-la-saison-14-de-g-624x600-1.jpg'
        ],

        [
            'title' => 'Game of thrones',
            'summary' => "Sur le continent de Westeros, le roi Robert Baratheon gouverne le Royaume des Sept Couronnes depuis plus de dix-sept ans, à la suite de la rébellion qu'il a menée contre le « roi fou » Aerys II Targaryen. Jon Arryn, époux de la sœur de Lady Catelyn Stark, Lady Arryn, son guide et principal conseiller, vient de s'éteindre, et le roi part alors dans le nord du royaume demander à son vieil ami Eddard « Ned » Stark de remplacer leur regretté mentor au poste de Main du roi. ",
            'category' => 'category_4',
            'actor' => ['actor_7', 'actor_8', 'actor_9'],
            'poster' => 'https://m.media-amazon.com/images/I/91DjGXn7jXL._AC_SL1500_.jpg'
        ],

        [
            'title' => 'Blacklist',
            'summary' => 'La série, qui se déroule principalement à Washington, raconte l\'histoire d\'un ancien officier de l\'US Navy, Raymond « Red » Reddington, qui a disparu vingt ans plus tôt pour devenir l\'un des dix fugitifs les plus recherchés du FBI et un criminel de premier plan, surnommé le "Médiateur du crime". Reddington se rend volontairement au FBI, dans son quartier général.',
            'category' => 'category_1',
            'actor' => ['actor_10', 'actor_11', 'actor_12'],
            'poster' => 'https://photos.tf1.fr/700/933/vignette-portrait-68932b-39e634-0@1x.jpg'
        ],

    ];

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $show) {
            $program = new Program();

            $program->setTitle($show['title']);
            $program->setSummary($show['summary']);
            $program->setCategory($this->getReference($show['category']));
            $program->setPoster($show['poster']);
            for ($i = 0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            }

            $slug = $this->slugify->generate($program->getTitle());
            $program->setSlug($slug);

            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ActorFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
