<?php


namespace App\Service;


use App\Entity\Brand;
use App\Entity\User;

class FilterObjectsBrand
{
    public function getIdsBrand($user)
    {
        /** @var User $user $idBrandsOfUser */
        $idBrandsOfUser = [];
        foreach ($user->getBrands() as $brand) {
            /** @var Brand $brand */
            $idBrandsOfUser['brand'][] = $brand->getId();
        }
        return $idBrandsOfUser;
    }
}