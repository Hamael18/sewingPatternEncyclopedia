<?php

namespace App\Controller;

use App\Entity\Gender;
use App\Form\NewGenderType;
use App\Repository\GenderRepository;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminGenderController extends BaseAdminController
{
    /**
     * @Route("/admin/pattern/gender/{page<\d+>?1}", name="admin_gender")
     * @param GenderRepository $genderRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listGenders(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Gender::class)
            ->setRoute('admin_gender')
            ->setPage($page)
            ;
        return $this->render('admin/gender/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/admin/pattern/gender/new", name="admin_gender_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newGender(Request $request)
    {
        $gender = new Gender();
        $form = $this->createForm(NewGenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($gender);
            $this->manager->flush();
            $this->addFlash('success', "Nouveu genre ajouté avec succès !");
            return $this->redirectToRoute('admin_gender');
        }
        return $this->render('admin/gender/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/pattern/gender/edit/{id}", name="admin_gender_edit")
     * @param Request $request
     * @param Gender $gender
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editBrand(Request $request, Gender $gender)
    {
        $form = $this->createForm(NewGenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Genre modifiée avec succès !");
            return $this->redirectToRoute('admin_gender');
        }
        return $this->render('admin/gender/edit.html.twig', [
            'form' => $form->createView(),
            'gender' => $gender
        ]);
    }

    /**
     * @Route("/admin/pattern/gender/delete/{id}", name="admin_gender_delete")
     * @param Gender $gender
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteBrand(Gender $gender)
    {
        $this->manager->remove($gender);
        $this->manager->flush();
        $this->addFlash('success', "Genre supprimé avec succès !");
        return $this->redirectToRoute('admin_gender');
    }
}
