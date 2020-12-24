<?php


namespace App\Controller;


use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\User;
use App\Repository\ProductRepository;
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

class DefaultController extends AbstractController
{
    /**
     * @Route("products/{page<\d+>?1}", name="list_products", methods={"GET"})
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(Request $request, ProductRepository $productRepository,
    SerializerInterface $serializer)
    {
        $page = $request->query->get('page');

        if(is_null($page) || $page < 1) {
            $page = 1;
        }

        $limit = 10;
        $products = $productRepository->findAllProducts($page, getenv('LIMIT'));

        $data = $serializer->serialize($products, 'json');

        return new Response(
            $data, 200,  [
            'Content-Type' => 'application/json'
        ]);
    }

}