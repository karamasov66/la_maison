<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Category;
use App\Entity\Product;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $productRepo = $this->getDoctrine()->getRepository(Product::class);
        $query = $productRepo->createQueryBuilder('p')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)?? 1,
            6
        );

        $pagination->setCustomParameters( [
            'align' => 'center',
            'size' => 'small',
            // 'style' => 'bottom'
        ]);

        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    public function showMainMenu($routeName, $params) {

        $catRepo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $catRepo->findAll();


        return $this->render('partials/main_menu.html.twig', [
            'categories' => $categories,
            'routeName' => $routeName,
            'params' => $params
        ]);

    }

}
