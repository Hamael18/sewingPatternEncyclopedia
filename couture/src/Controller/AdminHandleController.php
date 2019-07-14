<?php

namespace App\Controller;

use App\Entity\Handle;
use App\Form\HandleType;
use App\Repository\HandleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminHandleController extends BaseController
{
    /**
     * @Route("/admin/handle", name="admin_handle")
     */
    public function index(HandleRepository $repository)
    {
        return $this->render('admin/handle/index.html.twig', [
            'handles' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/handle/new", name="admin_handle_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newCollar(Request $request)
    {
        $handle = new Handle();
        $form = $this->createForm(HandleType::class, $handle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($handle);
            $this->manager->flush();
            $this->addFlash('success', "Manches ajoutées avec succès !");
            return $this->redirectToRoute('admin_handle');
        }

        return $this->render('admin/handle/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/handle/edit/{id}", name="admin_handle_edit")
     * @param Request $request
     * @param Handle $handle
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editStyle(Request $request, Handle $handle)
    {
        $form = $this->createForm(HandleType::class, $handle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Manches modifiées avec succès !");
            return $this->redirectToRoute('admin_handle');
        }

        return $this->render('admin/handle/edit.html.twig', [
            'form' => $form->createView(),
            'handle' => $handle
        ]);
    }

    /**
     * @Route("/admin/handle/delete/{id}", name="admin_handle_delete")
     * @param Handle $handle
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteStyle(Handle $handle)
    {
        $this->manager->remove($handle);
        $this->manager->flush();
        $this->addFlash('success', "Manches supprimées avec succès !");
        return $this->redirectToRoute('admin_handle');
    }

}
