<?php

namespace App\Controller;

use App\Entity\Version;
use App\Form\EmbedVersionType;
use App\Form\VersionType;
use App\Repository\PatternRepository;
use App\Repository\VersionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminVersionController extends BaseAdminController
{
    /**
     * @Route("/admin/version", name="admin_version")
     * @param VersionRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listVersions(VersionRepository $repository)
    {
        return $this->render('admin/version/index.html.twig', [
            'versions' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/version/new", name="admin_version_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newVersion(Request $request)
    {
        $version = new Version();
        $form = $this->createForm(VersionType::class, $version);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($version);
            $this->manager->flush();
            $this->addFlash('success', "Version ajoutée avec succès !");
            return $this->redirectToRoute('admin_version');
        }

        return $this->render('admin/version/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/version/edit/{id}", name="admin_version_edit")
     * @param Request $request
     * @param Version $version
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editVersion(Request $request, Version $version)
    {
        $form = $this->createForm(VersionType::class, $version);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Version modifiée avec succès !");
            return $this->redirectToRoute('admin_version');
        }

        return $this->render('admin/version/edit.html.twig', [
            'form' => $form->createView(),
            'version' => $version,
            'pattern' => $version->getPattern()
        ]);
    }

    /**
     * @Route("/admin/version/delete/{id}", name="admin_version_delete")
     * @param Version $version
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteVersion(Version $version)
    {
        $this->manager->remove($version);
        $this->manager->flush();
        $this->addFlash('success', "Version supprimée avec succès !");
        return $this->redirectToRoute('admin_version');
    }
}
