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
    public function adminIndex()
    {
        return $this->render('admin/dashboard/dashboard.html.twig');
    }

    /**
     * @Route("/marque", name="marque_dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function marqueIndex()
    {
        return $this->render('marque/dashboard/dashboard.html.twig');
    }
}
