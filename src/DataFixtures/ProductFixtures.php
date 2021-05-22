<?php


namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 500; $i++)
        {
            $product = new Product();

            $product->setName('Product ' . $i);
            $product->setPrice($i . ' SYP');
            $product->setImage(100000 + $i);
            $product->setSupplier((500000 - $i));

            $manager->persist($product);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}