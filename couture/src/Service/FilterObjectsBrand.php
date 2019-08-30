<?php


namespace App\Service;


use App\Entity\Brand;
use App\Entity\User;

class FilterObjectsBrand
{
    public function getIdsBrand(User $user)
    {
        $idBrandsOfUser = [];
        foreach ($user->getBrands() as $brand) {
            /** @var Brand $brand */
            $idBrandsOfUser[] = $brand->getId();
        }
        return $idBrandsOfUser;
    }
}