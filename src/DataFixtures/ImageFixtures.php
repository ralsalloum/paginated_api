<?php


namespace App\DataFixtures;


use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 500; $i++)
        {
            $image = new Image();

            $image->setImagePath('image/' . $i);

            $manager->persist($image);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group3'];
    }
}