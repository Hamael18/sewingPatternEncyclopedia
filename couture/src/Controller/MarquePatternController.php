<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Pattern;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MarquePatternController extends BaseAdminController
{
    /**
     * @Route("/marque/pattern/{page<\d+>?1}", name="marque_pattern")
     */
    public function listPatterns(Pagination $pagination, $page)
    {
        $idBrandsOfUser = [];
        foreach ($this->getUser()->getBrands() as $brand) {
            /** @var Brand $brand */
            $idBrandsOfUser[] = $brand->getId();
        }

        $pagination ->setEntityClass(Pattern::class)
                    ->setRoute('marque_pattern')
                    ->setPage($page)
                    ->setCriteres(['brand' => $idBrandsOfUser])
        ;

        return $this->render('marque/pattern/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/marque/pattern/new", name="marque_pattern_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newPattern(Request $request)
    {
        $pattern = new Pattern();
        $form = $this->createForm(PatternType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($pattern->getVersions() as $version) {
                $version->setPattern($pattern);
                $pattern->addVersion($version);
                $this->manager->persist($version);
            }
            $this->manager->persist($pattern);
            $this->manager->flush();
            $this->addFlash('success', "Patron créé avec succès !");
            return $this->redirectToRoute('marque_pattern');
        }

        return $this->render('marque/pattern/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/marque/pattern/edit/{id}", name="marque_pattern_edit")
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
            return $this->redirectToRoute('marque_pattern');
        }

        return $this->render('marque/pattern/edit.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern
        ]);
    }

    /**
     * @Route("/marque/pattern/delete/{id}", name="marque_pattern_delete")
     * @param Pattern $pattern
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletePattern(Pattern $pattern)
    {
        $this->manager->remove($pattern);
        $this->manager->flush();
        $this->addFlash('success', "Patron supprimé avec succès !");
        return $this->redirectToRoute('marque_pattern');
    }

    /**
     * @Route("/marque/pattern/add_version/{id}", name="marque_pattern_addVersion")
     * @param Request $request
     * @param Pattern $pattern
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addVersionToPattern(Request $request, Pattern $pattern)
    {
        $version = new Version();
        $form = $this->createForm(VersionType::class, $version);
        $form->remove('pattern');
        $version->setPattern($pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($version);
            $this->manager->flush();
            $this->addFlash('success', "Version ajoutée avec succès !");
            return $this->redirectToRoute('marque_version');
        }

        return $this->render('marque/pattern/_addVersion.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern
        ]);
    }
}
