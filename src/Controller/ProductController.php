<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_product')]
    public function index(
        Request $request,
        ProductRepository $productRepository,
        PaginatorInterface $paginator
    ): Response
    {
        // Отримуємо GET-параметр category з URL: /products?category=sushi
        $category = $request->query->get('category');

        // Використовуємо QueryBuilder для можливості пагінації
        $queryBuilder = $category
            ? $productRepository->createQueryBuilder('p')
                ->where('p.category = :category')
                ->setParameter('category', $category)
            : $productRepository->createQueryBuilder('p');

        // Пагінація: 5 товарів на сторінку
        $products = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1), // номер сторінки
            3 // кількість товарів на сторінку
        );

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'selected_category' => $category,
        ]);
    }
}
