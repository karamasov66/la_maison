<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class AdminController extends AbstractController {

    public function showAdminMenu($routeName) {
        return $this->render('admin/partials/admin_menu.html.twig', [
            'routeName' => $routeName
        ]);
    }

}