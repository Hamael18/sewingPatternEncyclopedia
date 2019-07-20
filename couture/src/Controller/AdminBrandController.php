<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandOwnerType;
use App\Form\NewBrandType;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminBrandController extends BaseAdminController
{
    /**
     * @Route("/admin/brand/{page<\d+>?1}", name="admin_brand")
     */
    public function listBrand(Pagination $pagination, $page)
    {
        $pagination ->setEntityClass(Brand::class)
                    ->setRoute('admin_brand')
                    ->setPage($page)
        ;
        return $this->render('admin/brand/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/brand/new", name="admin_brand_new")
     */
    public function createBrand(Request $request)
    {
        $brand = new Brand();
        $form = $this->createForm(NewBrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($brand);
            $this->manager->flush();
            $this->addFlash('success', "Marque créé avec succès !");
            return $this->redirectToRoute('admin_brand');
        }
        return $this->render('admin/brand/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/brand/edit/{id}", name="admin_brand_edit")
     * @param Request $request
     * @param Brand $brand
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editBrand(Request $request, Brand $brand)
    {
        $form = $this->createForm(NewBrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Marque modifiée avec succès !");
            return $this->redirectToRoute('admin_brand');
        }
        return $this->render('admin/brand/edit.html.twig', [
            'form' => $form->createView(),
            'brand' => $brand
        ]);
    }

    /**
     * @Route("/admin/brand/delete/{id}", name="admin_brand_delete")
     * @param Brand $brand
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteBrand(Brand $brand)
    {
        $this->manager->remove($brand);
        $this->manager->flush();
        $this->addFlash('success', "Marque supprimée avec succès !");
        return $this->redirectToRoute('admin_brand');
    }

    /**
     * @Route("admin/brand/{id}/add_owner", name="admin_brand_addOwner")
     */
    public function addOwner(Request $request, Brand $brand)
    {
        $form = $this->createForm(BrandOwnerType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "L'utilisateur a été identifié comme propriétaire de la marque");
            return $this->redirectToRoute('admin_brand');
        }
        return $this->render('admin/brand/addOwner.html.twig', [
            'form' => $form->createView(),
            'brand' => $brand
        ]);
    }
}
