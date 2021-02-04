<?php

namespace App\Controller;

use App\Entity\Product;
use App\Data\SearchProductData;
use App\Form\SearchProductType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends AbstractController
{
    /**
     * @Route("/produits", name="products")
     */
    public function index(PaginatorInterface $paginator, ProductRepository $productRepository, Request $request): Response
    {
        $search = new SearchProductData();
        $searchForm = $this->createForm(SearchProductType::class, $search);
        $searchForm->handleRequest($request);

        $results = [];
        $products = $productRepository->findAll();

        $donnees = $this->getDoctrine()->getRepository(Product::class)->findBy([],['id' => 'desc']);


        // Paginate the results of the query
        $products = $paginator->paginate(
            // Doctrine Query, not results
            $donnees,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $results = $productRepository->searchProduct($search);
        }
  
        return $this->render('product/index.html.twig', [
            'products' => $results ? $results : $products,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/produits/{slug}", name="product_show")
     * @ParamConverter("product", class="App\Entity\Product", options={"mapping": {"slug": "slug"}})
     */
    public function showProduct(Product $product, ProductRepository $productRepository): Response
    {
        $categories = $product->getCategory();
        
        return $this->render('product/show.html.twig', [
       'product' => $product,
       'categories' => $categories,
       ]);
    }
}
