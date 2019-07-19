<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("accueil", name="accueil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accueil()
    {
        return $this->render('index.html.twig');
    }
}
