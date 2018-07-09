<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Sort;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Ordering;
use ONGR\ElasticsearchDSL\Sort\FieldSort;

final class SortByFieldQueryFactory implements SortFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(Ordering $ordering)
    {
        $queries = [];
        foreach ($ordering->getSortFields() as $sortField=>$sortDirection) {
            $queries[] = new FieldSort('raw_' . $sortField, $sortDirection);
        }
        return $queries;
    }
}
