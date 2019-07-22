<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Service\Pagination;
use Symfony\Component\Routing\Annotation\Route;

class MarqueBrandController extends BaseAdminController
{
    /**
     * @Route("/marque/brand/{page<\d+>?1}", name="marque_brand")
     * @param Pagination $pagination
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listBrands(Pagination $pagination, $page)
    {
        $pagination ->setEntityClass(Brand::class)
                    ->setRoute('marque_brand')
                    ->setPage($page)
                    ->setCriteres(['owner' => $this->getUser()->getId()])
        ;

        return $this->render('marque/brand/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
