<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $httpClient
    ){

    }


    #[Route('/home', name: 'home', methods:'GET')]
    public function home(Request $request, ProductRepository $productRepository, PaginatorInterface $paginator, LoggerInterface $logger)
    {
        $logger->info('New product added++++++');
        $queryBuilder = $productRepository->createQueryBuilder('p');
        $pagination = $paginator->paginate(
            $queryBuilder, // Requête
            $request->query->getInt('page', 1), // Numéro de la page
            10 // Nombre d'éléments par page
        );

        return $this->render('product/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/products', name: 'products', methods:'POST')]
    public function products(Request $request): Response
    {

        return $this->render('product/index.html.twig');
    }


    #[Route('/inventory', name: 'inventory')]
    public function inventory(): Response
    {
        return $this->render('inventory/index.html.twig');
    }

    #[Route('/erp/products', name: 'erpProducts', methods:'POST')]
    public function erpProducts(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        foreach($data as $element){
            $product = $em->getRepository(Product::class)->findOneBy(['reference' => $element['reference']]);
            if(!$product){
                $product = new Product();
                $product->setReference($element['reference']);
                $product->setCreatedAt(new DateTimeImmutable());
            }
            $product->setName($element['name']);
            $product->setDropshipping($element['dropshipping'] === 'true');
            $product->setCategory($element['category']);
            $product->setDescription($element['description']);
            $em->persist($product);
        }
        $em->flush();
        return new JsonResponse(['status'=> "send"], 200);
    }
}
