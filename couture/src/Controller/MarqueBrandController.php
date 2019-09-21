<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueBrandController extends BaseAdminController
{
    /**
     * @Route("/marque/brand/{slug}", name="marque_brand_homepage")
     *
     * @param Brand $brand
     *
     * @return Response
     */
    public function showBrand(Brand $brand)
    {
        return $this->render('marque/brand/show.html.twig', [
            'brand' => $brand
        ]);
    }

    /**
     * @Route("/marque/brand/{page<\d+>?1}", name="marque_brand")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     */
    public function listBrands(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Brand::class)
            ->setRoute('marque_brand')
            ->setPage($page)
            ->setCriteres(['owner' => $this->getUser()->getId()]);

        return $this->render('marque/brand/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/marque/brand/edit/{id}", name="marque_brand_edit")
     *
     * @param Request $request
     * @param Brand   $brand
     *
     * @return RedirectResponse|Response
     */
    public function editBrand(Request $request, Brand $brand)
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Marque modifiée avec succès !");
            return $this->redirectToRoute('marque_brand');
        }

        return $this->render('marque/brand/edit.html.twig', [
            'form' => $form->createView(),
            'brand' => $brand
        ]);
    }

    /**
     * @Route("/marque/brand/delete/{id}", name="marque_brand_delete")
     *
     * @param Brand $brand
     *
     * @return RedirectResponse
     */
    public function deleteBrand(Brand $brand)
    {
        $this->manager->remove($brand);
        $this->manager->flush();
        $this->addFlash('success', "Marque supprimée avec succès !");
        return $this->redirectToRoute('marque_brand');
    }
}
