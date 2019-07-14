<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\NewLanguageType;
use App\Repository\LanguageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLanguageController extends BaseAdminController
{
    /**
     * @Route("/admin/pattern/language", name="admin_language")
     */
    public function listLanguages(LanguageRepository $repository)
    {
        return $this->render('admin/language/index.html.twig', [
            'languages' => $repository->findAll()
        ]);
    }
    /**
     * @Route("/admin/pattern/language/new", name="admin_language_new")
     */
    public function newLanguage(Request $request)
    {
        $language = new Language();
        $form = $this->createForm(NewLanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($language);
            $this->manager->flush();
            $this->addFlash('success', "Nouvelle langue ajouté avec succès !");
            return $this->redirectToRoute('admin_language');
        }
        return $this->render('admin/language/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/pattern/language/edit/{id}", name="admin_language_edit")
     * @param Request $request
     * @param Language $language
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editLanguage(Request $request, Language $language)
    {
        $form = $this->createForm(NewLanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Langue modifiée avec succès !");
            return $this->redirectToRoute('admin_language');
        }
        return $this->render('admin/language/edit.html.twig', [
            'form' => $form->createView(),
            'language' => $language
        ]);
    }

    /**
     * @Route("/admin/pattern/language/delete/{id}", name="admin_language_delete")
     * @param Language $language
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteLanguage(Language $language)
    {
        $this->manager->remove($language);
        $this->manager->flush();
        $this->addFlash('success', "Langue supprimée avec succès !");
        return $this->redirectToRoute('admin_language');
    }
}
