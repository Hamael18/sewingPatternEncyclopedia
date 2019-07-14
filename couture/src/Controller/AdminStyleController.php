<?php

namespace App\Controller;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminStyleController extends BaseController
{
    /**
     * @Route("/admin/style", name="admin_style")
     */
    public function index(StyleRepository $repository)
    {
        return $this->render('admin/style/index.html.twig', [
            'styles' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/style/new", name="admin_style_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newStyle(Request $request)
    {
        $style = new Style();
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($style);
            $this->manager->flush();
            $this->addFlash('success', "Style ajouté avec succès !");
            return $this->redirectToRoute('admin_style');
        }

        return $this->render('admin/style/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/style/edit/{id}", name="admin_style_edit")
     * @param Request $request
     * @param Style $style
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editStyle(Request $request, Style $style)
    {
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Style modifié avec succès !");
            return $this->redirectToRoute('admin_style');
        }

        return $this->render('admin/style/edit.html.twig', [
            'form' => $form->createView(),
            'style' => $style
        ]);
    }

    /**
     * @Route("/admin/style/delete/{id}", name="admin_style_delete")
     * @param Style $style
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteStyle(Style $style)
    {
        $this->manager->remove($style);
        $this->manager->flush();
        $this->addFlash('success', "Style supprimé avec succès !");
        return $this->redirectToRoute('admin_style');
    }
}
