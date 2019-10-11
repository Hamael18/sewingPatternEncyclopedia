<?php

namespace App\Controller;

use Elastica\Client;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElasticController extends AbstractController
{
    /**
     * @route("/searchTest", name="searchTest")
     */
    public function elasticaSearchTest(Request $request, Client $client): Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->render('elastic/search.html.twig');
        }

        $query = $request->query->get('q', '');
        $limit = $request->query->get('l', 10);

        $match = new MultiMatch();
        $match->setQuery($query);
        $match->setFields(['name', 'description', 'owner']);

        $bool = new BoolQuery();
        $bool->addShould($match);

        $elasticaQuery = new Query($bool);
        $elasticaQuery->setSize($limit);

        $found = $client->getIndex('brand')->search($elasticaQuery);
        $results = [];
        foreach ($found as $brand) {
            $results[] = $brand->getSource();
        }

        $wech = $client->getIndex('pattern')->search($elasticaQuery);
        foreach ($wech as $pattern) {
            $results[] = $pattern->getSource();
        }

        return $this->json($results);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(): Response
    {
        return $this->render('elastic/index.html.twig', [
            'controller_name' => 'ElasticController',
        ]);
    }
}
