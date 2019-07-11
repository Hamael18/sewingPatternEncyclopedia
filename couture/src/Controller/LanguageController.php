<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\NewLanguageType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    /**
     * @Route("admin/language", name="admin_language")
     */
    public function index()
    {
        return $this->render('language/index.html.twig', [
            'controller_name' => 'LanguageController',
        ]);
    }
    /**
     * @Route("admin/language/new", name="admin_language_new")
     */
    public function createLanguage(Request $request, ObjectManager $manager)
    {
        $language = new Language();
        $form = $this->createForm(NewLanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($language);
            $manager->flush();
            $this->addFlash('success', "Nouveau langage ajouté avec succès !");
            return $this->redirectToRoute('admin/dashboard');
        }
        return $this->render('admin/language/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
