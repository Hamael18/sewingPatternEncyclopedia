<?php

namespace App\Controller;

use App\Entity\Collar;
use App\Form\CollarType;
use App\Repository\CollarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCollarController extends BaseController
{
    /**
     * @Route("/admin/collar", name="admin_collar")
     */
    public function index(CollarRepository $repository)
    {
        return $this->render('admin/collar/index.html.twig', [
            'collars' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/collar/new", name="admin_collar_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newCollar(Request $request)
    {
        $collar = new Collar();
        $form = $this->createForm(CollarType::class, $collar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($collar);
            $this->manager->flush();
            $this->addFlash('success', "Col ajouté avec succès !");
            return $this->redirectToRoute('admin_collar');
        }

        return $this->render('admin/collar/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/collar/edit/{id}", name="admin_collar_edit")
     * @param Request $request
     * @param Collar $collar
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editStyle(Request $request, Collar $collar)
    {
        $form = $this->createForm(CollarType::class, $collar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Col modifié avec succès !");
            return $this->redirectToRoute('admin_collar');
        }

        return $this->render('admin/collar/edit.html.twig', [
            'form' => $form->createView(),
            'style' => $collar
        ]);
    }

    /**
     * @Route("/admin/collar/delete/{id}", name="admin_collar_delete")
     * @param Collar $collar
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteStyle(Collar $collar)
    {
        $this->manager->remove($collar);
        $this->manager->flush();
        $this->addFlash('success', "Col supprimé avec succès !");
        return $this->redirectToRoute('admin_collar');
    }
}
