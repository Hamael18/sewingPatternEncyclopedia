<?php

namespace App\Controller;

use Elastica\Client as ElasticaClient;
use Elasticsearch\ClientBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ElasticController extends AbstractController
{
    protected $elasticSearch;
    
    protected $elastica;

    public function __construct()
    {
        $this->elasticSearch = ClientBuilder::create()->build();

        $elasticaConfig = [
            'host'=> 'localhost',
            'port'=> 9200,
            'index'=>'customer'
        ];

        $this->elastica = new ElasticaClient($elasticaConfig);
    }

    /**
     * @route("/searchTest", name="searchTest")
     */
    public function elasticaSearchTest() : Response
    {
        dump($this->elasticSearch);

        echo "Document : \n";
        $param = [
            'index'=>'customer',
            'type'=>'_doc',
            'id'=>'1'
        ];
        $response = $this->elasticSearch->get($param);
        dump($response);

        return $this->search();
    }

    /**
     * @Route("/search", name="search")
     */
    public function search() : Response
    {
        return $this->render('elastic/index.html.twig', [
            'controller_name' => 'ElasticController',
        ]);
    }
}