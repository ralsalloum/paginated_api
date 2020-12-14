<?php


namespace App\Controller;


use App\Entity\Product;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $productRepository = $em->getRepository(Product::class);

        $query = $productRepository->createQueryBuilder('p')->getQuery();

        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('default/index.html.twig', [
            'products'=>$products
        ]);
    }
}