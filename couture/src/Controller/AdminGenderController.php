<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminGenderController extends AbstractController
{
    /**
     * @Route("/admin/gender", name="admin_gender")
     */
    public function index()
    {
        return $this->render('admin_gender/index.html.twig', [
            'controller_name' => 'AdminGenderController',
        ]);
    }
}
