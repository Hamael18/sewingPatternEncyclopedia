<?php

namespace App\Controller;

use App\Entity\Level;
use App\Form\NewLevelType;
use App\Repository\LevelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLevelController extends BaseController
{
    /**
     * @Route("/admin/level", name="admin_level")
     */
    public function index(LevelRepository $repository)
    {
        return $this->render('admin/level/list.html.twig', [
            'levels' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/level/new", name="admin_level_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newLevel(Request $request)
    {
        $level = new Level();
        $form= $this->createForm(NewLevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($level);
            $this->manager->flush();
            $this->addFlash('success', "Niveau de patron créé avec succès !");
            return $this->redirectToRoute('admin_level');
        }

        return $this->render('admin/level/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/level/edit/{id}", name="admin_level_edit")
     * @param Request $request
     * @param Level $level
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editLevel(Request $request, Level $level)
    {
        $form= $this->createForm(NewLevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Niveau de patron modifié avec succès !");
            return $this->redirectToRoute('admin_level');
        }

        return $this->render('admin/level/edit.html.twig', [
            'form' => $form->createView(),
            'level' => $level
        ]);
    }

    /**
     * @Route("/admin/level/delete/{id}", name="admin_level_delete")
     * @param Level $level
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteLevel(Level $level)
    {
        $this->manager->remove($level);
        $this->manager->flush();
        $this->addFlash('success', "Niveau de patron supprimé avec succès !");
        return $this->redirectToRoute('admin_level');
    }
}