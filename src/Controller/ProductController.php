<?php


namespace App\Controller;


use App\AutoMapping;
use App\Service\ProductService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends BaseController
{
    private $productService;
    private $autoMapping;
    private $serializer;

    public function __construct(ProductService $productService, AutoMapping $autoMapping,
                                SerializerInterface $serializer)
    {
        parent::__construct($serializer);
        $this->productService = $productService;
        $this->autoMapping = $autoMapping;
        $this->serializer = $serializer;
    }

    //Paginated RESTFUL API
    /**
     * @Route("products/{page}", name="list_products", methods={"GET"})
     * @return Response
     */
    public function getProducts($page)
    {
        $limit = 100;    //Can be defined in .env later

        $products = $this->productService->getProducts($page, $limit);

//        $data = $this->serializer->serialize($products, 'json');
//        return new Response($data, 200, [
//            'Content-Type' => 'application/json'
//        ]);

        return $this->response($products, self::FETCH);
    }

    //Paginated Twig API
    /**
     * @Route("productstwig", name="getProductsInTwig", methods={"GET"})
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function getProductsTwig(Request $request, PaginatorInterface $paginator)
    {
        $paginatedProducts = $this->productService->getPaginatedProducts($request);

        return $this->render('default/index.html.twig', [
            'products'=>$paginatedProducts
        ]);
    }

    /**
     * @Route("product/{price}", name="getProductByPrice", methods={"GET"})
     */
    public function getProductByPrice($price)
    {
        $result = $this->productService->getProductByPrice($price);

        return $this->response($result, self::FETCH);
    }
}