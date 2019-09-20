<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\User;
use App\Form\AddBrandsToUserType;
use App\Form\AdminSearchUserType;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends BaseAdminController
{
    /**
     * @Route("/admin/user/{page<\d+>?1}", name="admin_user")
     *
     * @param Pagination $pagination
     * @param            $page
     * @param Request    $request
     *
     * @return Response
     */
    public function listUsers(Pagination $pagination, $page, Request $request)
    {
        $pagination->setEntityClass(User::class)
            ->setRoute('admin_user')
            ->setPage($page);

        $form = $this->createForm(AdminSearchUserType::class);
        $form->handleRequest($request);

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     *
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
        $this->addFlash('success', "Utilisateur supprimé avec succès !");
        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/admin/user/{id}/add_role/{role}", name="admin_user_addRole")
     *
     * @param User $user
     * @param      $role
     *
     * @return RedirectResponse
     */
    public function addRole(User $user, $role)
    {
        $add = $user->addRole($role);
        if ($add == false) {
            $this->addFlash('warning', "Cet utilisateur dispose déjà du droit " . $role);
            return $this->redirectToRoute('admin_user');
        }
        $this->manager->flush();
        $this->addFlash('success', "Utilisateur pourvu du " . $role);
        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/admin/user/{id}/remove_role/{role}", name="admin_user_removeRole")
     *
     * @param User $user
     * @param      $role
     *
     * @return RedirectResponse
     */
    public function removeRole(User $user, $role)
    {
        $remove = $user->removeRole($role);
        if ($remove == false) {
            $this->addFlash('warning', "Cet utilisateur ne possède pas le" . $role);
            return $this->redirectToRoute('admin_user');
        }
        $this->manager->flush();
        $this->addFlash('success', "Cet utilisateur n'a plus le role" . $role);
        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/admin/user/{id}/addBrands", name="admin_user_addBrands")
     *
     * @param Request $request
     * @param User    $user
     *
     * @return RedirectResponse|Response
     */
    public function addBrands(Request $request, User $user)
    {
        $form = $this->createForm(AddBrandsToUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()['brands'] as $brand) {
                /** @var Brand $brand */
                $user->addBrand($brand);
                $brand->setOwner($user);
                $this->manager->persist($brand);
            }
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success', "OK vite faut commiter");
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/addBrands.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/show/user/{id}", name="admin_user_show")
     *
     * @param User $user
     *
     * @return Response
     */
    public function showUser(User $user)
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user
        ]);
    }
}
