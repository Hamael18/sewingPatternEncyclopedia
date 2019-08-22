<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Pattern;
use App\Entity\Version;
use App\Form\PatternMarqueType;
use App\Form\SearchPatternType;
use App\Form\VersionType;
use App\Service\Pagination;
use App\Service\setFilterCriteres;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarquePatternController extends BaseAdminController
{
    /**
     * @Route("/marque/pattern/{page<\d+>?1}", name="marque_pattern")
     * @param Pagination $pagination
     * @param $page
     * @param Request $request
     * @param setFilterCriteres $filterCriteres
     * @return Response
     */
    public function listPatterns(Pagination $pagination, $page, Request $request, setFilterCriteres $filterCriteres)
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

        $form = $this->createForm(SearchPatternType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pagination = $filterCriteres->setFilter($form->getViewData(), $request);
            return $this->render('marque/pattern/index.html.twig', [
                'pagination' => $pagination,
                'form' => $form->createView()
            ]);
        }

        return $this->render('marque/pattern/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/marque/pattern/new", name="marque_pattern_new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newPattern(Request $request)
    {
        $pattern = new Pattern();
        $form = $this->createForm(PatternMarqueType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($pattern);
            $this->manager->flush();
            $this->addFlash('success', "Patron de couture créé avec succès !");
            return $this->redirectToRoute('marque_pattern');
        }

        return $this->render('marque/pattern/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/marque/pattern/add_version/{id}", name="marque_pattern_addVersion")
     * @param Request $request
     * @param Pattern $pattern
     * @return RedirectResponse|Response
     */
    public function addVersionPattern(Request $request, Pattern $pattern)
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
            return $this->redirectToRoute('marque_pattern');
        }

        return $this->render('_admin_marque/pattern/_addVersion.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern
        ]);
    }

    /**
     * @Route("/marque/pattern/edit/{id}", name="marque_pattern_edit")
     * @param Request $request
     * @param Pattern $pattern
     * @return RedirectResponse|Response
     */
    public function editPattern(Request $request, Pattern $pattern)
    {
        $form = $this->createForm(PatternMarqueType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Patron de couture créé avec succès !");
            return $this->redirectToRoute('marque_pattern');
        }

        return $this->render('marque/pattern/new.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern
        ]);
    }

    /**
     * @Route("/marque/pattern/delete/{id}", name="marque_pattern_delete")
     * @param Pattern $pattern
     * @return RedirectResponse
     */
    public function deletePattern(Pattern $pattern)
    {
        $this->manager->remove($pattern);
        $this->manager->flush();
        $this->addFlash('success', "Patron de couture supprimé avec succès !");
        return $this->redirectToRoute('marque_pattern');
    }
}
