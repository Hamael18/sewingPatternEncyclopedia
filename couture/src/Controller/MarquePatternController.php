<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Pattern;
use App\Form\PatternMarqueType;
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
        // On récupère les id des marques appartenant au user connecté
        $idBrandsOfUser = [];
        foreach ($this->getUser()->getBrands() as $brand) {
            /** @var Brand $brand */
            $idBrandsOfUser[] = $brand->getId();
        }

        // On set notre critère dans la requete (setCriteres)
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
}
