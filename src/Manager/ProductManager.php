<?php


namespace App\Manager;


use App\AutoMapping;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductManager
{
    private $entityManager;
    private $productRepository;
    private $autoMapping;
    private $paginator;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository,
                                AutoMapping $autoMapping)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->autoMapping = $autoMapping;
        //$this->paginator = $paginator;
    }

    public function getProducts($page, $limit)
    {
        if(is_null($page) || $page < 1) {
            $page = 1;
        }

        $query = $this->productRepository->findAllProductsQuery($page, $limit);

//        $query = $this->entityManager->createQuery($sql)
//            ->setFirstResult(($page - 1) * $limit)
//            ->setMaxResults($limit);
        
        $paginatedQuery = new Paginator($query, false);
        $paginatedQuery->setUseOutputWalkers(false);
        //$query->setHint('knp_paginator.count', $paginatedQuery->count());

        return $paginatedQuery;
    }

    public function getPaginatedProducts($request)
    {
        $query = $this->productRepository->getProductsQuery();

        $products = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            100
        );

        return $products;
    }

    public function getProductByPrice($price)
    {
        return $this->productRepository->getProductByPrice($price);
    }
}