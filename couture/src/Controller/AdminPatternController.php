<?php

namespace App\Controller;

use App\Entity\Pattern;
use App\Form\PatternType;
use App\Repository\PatternRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPatternController extends BaseAdminController
{
    /**
     * @Route("/admin/pattern", name="admin_pattern")
     * @param PatternRepository $patternRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPatterns(PatternRepository $patternRepository)
    {
        return $this->render('admin/pattern/list.html.twig', [
            'patterns' => $patternRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/pattern/new", name="admin_pattern_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newPattern(Request $request)
    {
        $pattern = new Pattern();
        $form = $this->createForm(PatternType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($pattern);
            $this->manager->flush();
            $this->addFlash('success', "Patron créé avec succès !");
            return $this->redirectToRoute('admin_pattern');
        }

        return $this->render('admin/pattern/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/pattern/edit/{id}", name="admin_pattern_edit")
     * @param Request $request
     * @param Pattern $pattern
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editPattern(Request $request, Pattern $pattern)
    {
        $form = $this->createForm(PatternType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Patron modifié avec succès !");
            return $this->redirectToRoute('admin_pattern');
        }

        return $this->render('admin/pattern/edit.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern
        ]);
    }

    /**
     * @Route("/admin/pattern/delete/{id}", name="admin_pattern_delete")
     * @param Pattern $pattern
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletePattern(Pattern $pattern)
    {
        $this->manager->remove($pattern);
        $this->manager->flush();
        $this->addFlash('success', "Patron supprimé avec succès !");
        return $this->redirectToRoute('admin_pattern');
    }
}
