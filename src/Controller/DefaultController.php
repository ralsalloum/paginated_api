<?php


namespace App\Controller;


use App\Entity\Product;
use App\Entity\User;
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

//    /**
//     * @Route("registeruser", name="registerUser", methods={"POST"})
//     * @param MailerInterface $mailer
//     * @return JsonResponse
//     * @throws TransportExceptionInterface
//     */
//    public function register(MailerInterface $mailer)
//    {
//            $user = new User();
//
//            $user->setEmail('user'.random_int(0, 5000).'@example.com');
//            $user->setPassword(000);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($user);
//            $em->flush();
//
//            $email = (new Email())
//                ->from('sym5@example.com')
//                ->to($user->getEmail())
//                ->subject('Welcome to Sym5')
//                ->text('Hello there!\n\n\n❤');
//
//            $mailer->send($email);
//
//        return $this->json('Done successfully');
//    }
}