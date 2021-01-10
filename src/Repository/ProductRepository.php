<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllProductsQuery($page, $limit)
    {
        $query = $this->createQueryBuilder('p')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $query
            ->select('p.name', 'p.price', 'image.imagePath', 'supplier.fullName')
            ->leftJoin(
                Supplier::class,
                'supplier',
                Join::WITH,
                'p.supplier = supplier.id')
            ->leftJoin(
                Image::class,
                'image',
                Join::WITH,
                'p.image = image.id');

        // $query
        //     ->setFirstResult(($page - 1) * $limit)
        //     ->setMaxResults($limit);

        return $query;
    }

    public function getProductsQuery()
    {
        return $this->createQueryBuilder('p')
            ->select('p.name', 'p.price', 'image.imagePath', 'supplier.fullName')
            ->leftJoin(
                Image::class,
                'image',
                Join::WITH,
                'p.image = image.id'
            )
            ->leftJoin(
                Supplier::class,
                'supplier',
                Join::WITH,
                'p.supplier = supplier.id'
            )
            ->setMaxResults(1000)
            ->getQuery();
    }
}
