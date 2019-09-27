<?php

namespace App\Elasticsearch;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Elastica\Client;
use Elastica\Document;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * Class BrandIndexer
 *
 * @author Julie
 */
class BrandIndexer
{
    private $client;

    private $brandRepository;

    private $router;

    public function __construct(Client $client, BrandRepository $brandRepository, UrlGeneratorInterface $router)
    {
        $this->client = $client;
        $this->brandRepository = $brandRepository;
        $this->router = $router;
    }

    public function buildDocument(Brand $brand)
    {
        $owner = ($brand->getOwner()) ?  $brand->getOwner()->getUsername() : "";
        $patterns = $brand->getPatterns();
        $patternsName = [];
        foreach ($patterns as $pattern) {
            $patternsName = [$pattern->getName()];
        }
        return new Document(
            $brand->getId(), // Manually defined ID
            [
                'name' => $brand->getName(),
                'description' => $brand->getDescription(),
                'patterns'=> $patternsName,

                // Not indexed but needed for display
                'owner' => $owner
            ]
        );
    }

    public function indexAllDocuments($indexName)
    {
        $allBrands = $this->brandRepository->findAll();
        $index = $this->client->getIndex($indexName);

        $documents = [];
        foreach ($allBrands as $brand) {
            $documents[] = $this->buildDocument($brand);
        }
dump($documents);
        $index->addDocuments($documents);
        $index->refresh();
    }
}