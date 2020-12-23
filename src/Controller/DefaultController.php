<?php


namespace App\Controller;


use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\User;
use Doctrine\ORM\Query\Expr\Join;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index(Request $request, PaginatorInterface $paginator)
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