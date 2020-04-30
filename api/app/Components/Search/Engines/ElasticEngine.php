<?php

namespace App\Components\Search\Engines;

use App\Components\Search\Search;
use App\Components\Search\Searchable;
use Elasticsearch\Client as ElasticSearchClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;

class ElasticEngine extends Engine
{

    protected ElasticSearchClient $elasticClient;

    public function __construct(ElasticSearchClient $elasticClient)
    {
        $this->elasticClient = $elasticClient;
    }

    /**
     * @inheritDoc
     */
    public function update($models)
    {
        /** @var Searchable $model */
        foreach ($models as $model) {
            $params = [
                'index' => $model->searchableAs(),
                'id' => $model->getScoutKey(),
                'body' => $model->toSearchableArray()
            ];
            $this->elasticClient->index($params);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete($models)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function search(Builder $builder)
    {
        $params = [
            'index' => $builder->index ?: $builder->model->searchableAs(),
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $builder->query,
                        'fields' => '*',
                    ]
                ],
                "highlight" => [
                    'fields' => [
                        'name' => new \StdClass(),
                        'email' => new \StdClass(),
                    ]
                ]
            ]
        ];

        return $this->elasticClient->search($params);
    }

    /**
     * @inheritDoc
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        $params = [
            'index' => $builder->index ?: $builder->model->searchableAs(),
            'body'  => [
                'from' => ($page*$perPage) - $perPage,
                'size' => $perPage,
                'query' => [
                    'multi_match' => [
                        'query' => $builder->query,
                        'fields' => '*',
                    ]
                ],
                "highlight" => [
                    'fields' => [
                        '*' => new \StdClass()
                    ]
                ]
            ]
        ];

        return $this->elasticClient->search($params);
    }

    /**
     * @inheritDoc
     */
    public function mapIds($results)
    {
        return collect($results['hits']['hits'])->pluck('_id');
    }

    /**
     * @inheritDoc
     */
    public function map(Builder $builder, $results, $model)
    {
        $ids = collect($results['hits']['hits'])->pluck('_id')->values()->all();
        return $model->whereIn($model->getKeyName(), $ids)->get();
    }

    public function highlight(Collection $results, $rawResults)
    {
        $hits = collect($rawResults['hits']['hits']);
        return $results->map(function (Model $model) use ($hits) {
            $key = $model->getKeyName();
            $found = $hits->first(fn($hit) => $hit['_id'] == $model->$key);
            return [
                'result' => $model,
                'highlight' => $found['highlight']
            ];
        });
    }

    /**
     * @inheritDoc
     */
    public function getTotalCount($results)
    {
        // TODO: Implement getTotalCount() method.
    }

    /**
     * @inheritDoc
     */
    public function flush($model)
    {
        // TODO: Implement flush() method.
    }
}
