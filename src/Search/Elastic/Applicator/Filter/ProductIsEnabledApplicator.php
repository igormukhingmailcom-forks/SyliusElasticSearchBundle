<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Filter;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductIsEnabledFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

/**
 * Class ProductIsEnabledApplicator
 * @package Lakion\SyliusElasticSearchBundle
 */
final class ProductIsEnabledApplicator extends SearchCriteriaApplicator
{
    /**
     * @var QueryFactoryInterface
     */
    private $productIsEnabledQueryFactory;

    /**
     * ProductIsEnabledApplicator constructor.
     * @param QueryFactoryInterface $productIsEnabledQueryFactory
     */
    public function __construct(QueryFactoryInterface $productIsEnabledQueryFactory)
    {
        $this->productIsEnabledQueryFactory = $productIsEnabledQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function applyProductIsEnabledFilter(ProductIsEnabledFilter $productIsEnabledFilter, Search $search)
    {
        $search->addFilter(
            $this->productIsEnabledQueryFactory->create([
                'enabled' => $productIsEnabledFilter->isEnabled()
            ]),
            BoolQuery::FILTER
        );
    }
}
