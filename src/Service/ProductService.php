<?php


namespace App\Service;


use App\AutoMapping;
use App\Manager\ProductManager;
use Symfony\Component\HttpFoundation\Request;

class ProductService
{
    private $productManager;
    private $autoMapping;

    public function __construct(ProductManager $productManager, AutoMapping $autoMapping)
    {
        $this->productManager = $productManager;
        $this->autoMapping = $autoMapping;
    }

    public function getProducts($page, $limit)
    {
        return $this->productManager->getProducts($page, $limit);
    }
}