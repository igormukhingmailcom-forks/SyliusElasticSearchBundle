<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Filter;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductIsPopularFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\ProductIsPopularQueryFactory;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

final class ProductIsPopularApplicator extends SearchCriteriaApplicator
{
    /**
     * @var ProductIsPopularQueryFactory
     */
    private $productIsPopularQueryFactory;

    /**
     * ProductIsPopularApplicator constructor.
     * @param QueryFactoryInterface $productIsPopularQueryFactory
     */
    public function __construct(QueryFactoryInterface $productIsPopularQueryFactory)
    {
        $this->productIsPopularQueryFactory = $productIsPopularQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function applyProductIsPopularFilter(ProductIsPopularFilter $productIsPopularFilter, Search $search)
    {
        $search->addFilter(
            $this->productIsPopularQueryFactory->create([
                'popular' => $productIsPopularFilter->isPopular()
            ]),
            BoolQuery::FILTER
        );
    }
}
