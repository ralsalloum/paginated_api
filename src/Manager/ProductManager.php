<?php


namespace App\Manager;


use App\AutoMapping;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductManager
{
    private $entityManager;
    private $productRepository;
    private $autoMapping;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository,
                                AutoMapping $autoMapping)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->autoMapping = $autoMapping;
    }

    public function getProducts($page, $limit)
    {
        if(is_null($page) || $page < 1) {
            $page = 1;
        }
        //dd($this->productRepository->findAllProducts($page, $limit));
        return $this->productRepository->findAllProducts($page, $limit);
    }
}