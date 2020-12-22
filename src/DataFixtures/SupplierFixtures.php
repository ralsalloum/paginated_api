<?php


namespace App\DataFixtures;


use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class SupplierFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 500000; $i++)
        {
            $supplier = new Supplier();

            $supplier->setFullName('supplier ' . $i);
            $supplier->setEmail('sup' . $i . '@example.com');
            $supplier->setCellphone($i);

            $manager->persist($supplier);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }
}