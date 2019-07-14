<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminStyleController extends AbstractController
{
    /**
     * @Route("/admin/style", name="admin_style")
     */
    public function index()
    {
        return $this->render('admin_style/index.html.twig', [
            'controller_name' => 'AdminStyleController',
        ]);
    }
}
