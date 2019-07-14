<?php

namespace App\Controller;

use App\Repository\VersionRepository;
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
}
