<?php

namespace App\Controller;

use App\Entity\Length;
use App\Form\LengthType;
use App\Repository\LengthRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLengthController extends BaseController
{
    /**
     * @Route("/admin/length", name="admin_length")
     */
    public function index(LengthRepository $repository)
    {
        return $this->render('admin/length/index.html.twig', [
            'lengths' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/length/new", name="admin_length_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newCollar(Request $request)
    {
        $length = new Length();
        $form = $this->createForm(LengthType::class, $length);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($length);
            $this->manager->flush();
            $this->addFlash('success', "Longueur ajoutée avec succès !");
            return $this->redirectToRoute('admin_length');
        }

        return $this->render('admin/length/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/length/edit/{id}", name="admin_length_edit")
     * @param Request $request
     * @param Length $length
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editStyle(Request $request, Length $length)
    {
        $form = $this->createForm(LengthType::class, $length);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Longueur modifiée avec succès !");
            return $this->redirectToRoute('admin_length');
        }

        return $this->render('admin/length/edit.html.twig', [
            'form' => $form->createView(),
            'style' => $length
        ]);
    }

    /**
     * @Route("/admin/length/delete/{id}", name="admin_length_delete")
     * @param Length $length
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteStyle(Length $length)
    {
        $this->manager->remove($length);
        $this->manager->flush();
        $this->addFlash('success', "Longueur supprimée avec succès !");
        return $this->redirectToRoute('admin_length');
    }
}
