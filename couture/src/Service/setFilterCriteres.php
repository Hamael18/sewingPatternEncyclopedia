<?php


namespace App\Service;


use App\Entity\Pattern;
use Symfony\Component\HttpFoundation\Request;

class setFilterCriteres
{
    private $pagination;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function setFilter($dataForm, Request $request)
    {
        $criteres = [];
        foreach ($dataForm['brand'] as $brand) {
                $criteres['brand'][] = $brand->getId();
        }

        $this->setPaginationService($criteres, $request);

        return $this->setPaginationService($criteres, $request);
    }

    public function setPaginationService($criteres, $request)
    {
        $filter = $this->pagination ->setEntityClass(Pattern::class)
                                    ->setRoute($request->attributes->get('_route'))
                                    ->setPage($request->attributes->get('page'))
                                    ->setCriteres($criteres);
        return $filter;
    }
}