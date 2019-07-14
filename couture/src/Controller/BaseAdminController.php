<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseAdminController extends AbstractController
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index()
    {
        return $this->render('admin/dashboard/dashboard.html.twig');
    }
}
