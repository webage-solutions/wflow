<?php

namespace App\Components\Search;

use App\Components\Search\Engines\ElasticEngine;
use Elasticsearch\ClientBuilder;
use Laravel\Scout\EngineManager;
use Laravel\Scout\ScoutServiceProvider;

class SearchServiceProvider extends ScoutServiceProvider
{
    public function boot()
    {
        resolve(EngineManager::class)->extend('elastic', function () {
            $builder = ClientBuilder::create();
            $builder->setHosts(['elasticsearch']);
            return new ElasticEngine($builder->build());
        });
    }
}
