<?php

namespace App\Controller;

use App\Entity\Fabric;
use App\Form\FabricType;
use App\Repository\FabricRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminFabricController extends BaseController
{
    /**
     * @Route("/admin/fabric", name="admin_fabric")
     */
    public function index(FabricRepository $repository)
    {
        return $this->render('admin/fabric/index.html.twig', [
            'fabrics' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/fabric/new", name="admin_fabric_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newFabric(Request $request)
    {
        $fabric = new Fabric();
        $form = $this->createForm(FabricType::class, $fabric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($fabric);
            $this->manager->flush();
            $this->addFlash('success', "Tissu ajouté avec succès !");
            return $this->redirectToRoute('admin_fabric');
        }

        return $this->render('admin/fabric/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/fabric/edit/{id}", name="admin_fabric_edit")
     * @param Request $request
     * @param Fabric $fabric
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editFabric(Request $request, Fabric $fabric)
    {
        $form = $this->createForm(FabricType::class, $fabric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Tissu modifié avec succès !");
            return $this->redirectToRoute('admin_fabric');
        }

        return $this->render('admin/fabric/edit.html.twig', [
            'form' => $form->createView(),
            'fabric' => $fabric
        ]);
    }

    /**
     * @Route("/admin/fabric/delete/{id}", name="admin_fabric_delete")
     * @param Fabric $fabric
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteFabric(Fabric $fabric)
    {
        $this->manager->remove($fabric);
        $this->manager->flush();
        $this->addFlash('success', "Tissu supprimé avec succès !");
        return $this->redirectToRoute('admin_fabric');
    }
}
