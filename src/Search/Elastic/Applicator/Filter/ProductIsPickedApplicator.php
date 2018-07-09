<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Filter;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductIsPickedFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

final class ProductIsPickedApplicator extends SearchCriteriaApplicator
{
    /**
     * @var QueryFactoryInterface
     */
    private $productIsPickedQueryFactory;

    /**
     * ProductIsPickedApplicator constructor.
     * @param QueryFactoryInterface $productIsPickedQueryFactory
     */
    public function __construct(QueryFactoryInterface $productIsPickedQueryFactory)
    {
        $this->productIsPickedQueryFactory = $productIsPickedQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function applyProductIsPickedFilter(ProductIsPickedFilter $productIsPickedFilter, Search $search)
    {
        $search->addFilter(
            $this->productIsPickedQueryFactory->create([
                'picked' => $productIsPickedFilter->isPicked()
            ]),
            BoolQuery::FILTER
        );
    }
}
