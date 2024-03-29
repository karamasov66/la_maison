<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $products = $productRepository->findAll();

        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1)?? 1,
            6
        );

        $pagination->setCustomParameters( [
            'align' => 'center',
            'size' => 'small',
            // 'style' => 'bottom'
        ]);

        return $this->render('product/index.html.twig', [
            '$pagination' => $products
        ]);
    }

    // /**
    //  * @Route("/new", name="product_new", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {
    //     $product = new Product();
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($product);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('product_index');
    //     }

    //     return $this->render('product/new.html.twig', [
    //         'product' => $product,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="product_show", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{slug}", name="product_code", methods={"GET"})
     */
    public function showByCode(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request, $slug) {

        $products = $productRepository->findByCode($slug);

        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1)?? 1,
            6
        );

        $pagination->setCustomParameters( [
            'align' => 'center',
            'size' => 'small',
            // 'style' => 'bottom'
        ]);

        return $this->render('product/show_by_code.html.twig', [
            'pagination' => $pagination,
            'code' => $slug
        ]);
    }

    // /**
    //  * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, Product $product): Response
    // {
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $product = $form->getData();
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($product);
    //         $em->flush();

    //         return $this->redirectToRoute('product_index');
    //     }

    //     return $this->render('product/edit.html.twig', [
    //         'product' => $product,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}", name="product_delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, Product $product): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($product);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('product_index');
    // }
}
