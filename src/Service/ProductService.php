<?php


namespace App\Service;


use App\AutoMapping;
use App\Manager\ProductManager;
use App\Response\GetProductResponse;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
        $paginatedResult = $this->productManager->getProducts($page, $limit);
        //dd($paginatedResult);
//        $response = [];
//
//        foreach ($paginatedResult as $key => $value)
//        {
//            dd($paginatedResult[$key]);
////            $response[] = $this->autoMapping->map(Paginator::class, GetProductResponse::class, $item[0]);
//        }
//
//        dd($response);
        return $paginatedResult;
    }

    public function getPaginatedProducts(Request $request)
    {
        return $this->productManager->getPaginatedProducts($request);
    }

    public function getProductByPrice($price)
    {
        $response = [];
        $product = $this->productManager->getProductByPrice($price);

        foreach($product as $item)
        {
            $response = $this->autoMapping->map('array', GetProductResponse::class, $item);
        }

        return $response;
    }
}