<?php

namespace App\Service;

use Elastica\Client;
use Symfony\Component\Yaml\Yaml;

class IndexBuilder
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create()
    {
        // We name our index "blog"
        $index = $this->client->getIndex('brand');

        $settings = Yaml::parse(
            file_get_contents(
                __DIR__.'/../../config/elasticsearch_index.yaml'
            )
        );

        // We build our index settings and mapping
        $index->create($settings, true);

        return $index;
    }
}
