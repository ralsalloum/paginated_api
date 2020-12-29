<?php


namespace App\Controller;


use App\AutoMapping;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use Doctrine\ORM\Query\Expr\Join;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
     * @Route("products/{page<\d+>?1}", name="list_products", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getProducts(Request $request)
    {
        $page = $request->query->get('page');

        $limit = 100;    //Can be defined in .env later
        //dd($page);
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
}