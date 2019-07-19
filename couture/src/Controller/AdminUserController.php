<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends BaseAdminController
{
    /**
     * @Route("/admin/user", name="admin_user")
     * @param UserRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listUsers(UserRepository $repository)
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
        $this->addFlash('success', "Utilisateur supprimé avec succès !");
        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/admin/user/{id}/add_role_marque/{role}", name="admin_user_addRole")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addRole(User $user, $role)
    {
        $add = $user->addRole($role);
        if ($add == false) {
            $this->addFlash('warning', "Cet utilisateur dispose déjà du droit ".$role);
            return $this->redirectToRoute('admin_user');
        }
        $this->manager->flush();
        $this->addFlash('success', "Utilisateur pourvu du ".$role);
        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/admin/user/{id}/remove_role_marque/{role}", name="admin_user_removeRole")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeRoleMarque(User $user, $role)
    {
        $remove = $user->removeRole($role);
        if ($remove == false) {
            $this->addFlash('warning', "Cet utilisateur ne possède pas le ROLE_MARQUE");
            return $this->redirectToRoute('admin_user');
        }
        $this->manager->flush();
        $this->addFlash('success', "Utilisateur n'a plus le role de marque");
        return $this->redirectToRoute('admin_user');
    }
}
