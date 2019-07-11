<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\NewBrandType;
use App\Repository\BrandRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminBrandController extends AbstractController
{
    /**
     * @Route("admin/brand", name="admin_brand")
     * @param BrandRepository $brandRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BrandRepository $brandRepo)
    {
        return $this->render('admin/brand/index.html.twig', [
            'brands' => $brandRepo->findAll(),
        ]);
    }

    /**
     * @Route("admin/brand/new", name="admin_brand_new")
     */
    public function createBrand(Request $request, ObjectManager $manager)
    {
        $brand = new Brand();
        $form = $this->createForm(NewBrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($brand);
            $manager->flush();
            $this->addFlash('success', "Marque créé avec succès !");
            return $this->redirectToRoute('admin_brand');
        }
        return $this->render('admin/brand/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
