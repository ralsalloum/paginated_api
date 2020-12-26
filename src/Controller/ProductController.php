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

    public function __construct(ProductService $productService, AutoMapping $autoMapping,
                                SerializerInterface $serializer)
    {
        parent::__construct($serializer);
        $this->productService = $productService;
        $this->autoMapping = $autoMapping;
    }

    //Paginated RESTFUL API
    /**
     * @Route("products/{page<\d+>?1}", name="list_products", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page');

        $limit = 10;    //Can be defined in .env later

        $products = $this->productService->getProducts($page, $limit);

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
        $em = $this->getDoctrine()->getManager();

        $productRepository = $em->getRepository(Product::class);

        $query = $productRepository->createQueryBuilder('p')
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

        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            100
        );

        return $this->render('default/index.html.twig', [
            'products'=>$products
        ]);
    }
}