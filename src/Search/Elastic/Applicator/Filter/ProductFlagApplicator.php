<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Filter;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductFlagFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

/**
 * Class ProductFlagApplicator
 * @package Lakion\SyliusElasticSearchBundle
 */
final class ProductFlagApplicator extends SearchCriteriaApplicator
{
    /**
     * @var QueryFactoryInterface|ProductFlagQueryFactoryØ
     */
    private $productFlagQueryFactory;

    /**
     * ProductFlagApplicator constructor.
     * @param QueryFactoryInterface $productFlagQueryFactory
     */
    public function __construct(QueryFactoryInterface $productFlagQueryFactory)
    {
        $this->productFlagQueryFactory = $productFlagQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function applyProductFlagFilter(ProductFlagFilter $productFlagFilter, Search $search)
    {
        $search->addFilter(
            $this->productFlagQueryFactory->create([
                'flagName' => $productFlagFilter->flagName(),
            ]),
            $productFlagFilter->flagValue() ? BoolQuery::MUST : BoolQuery::MUST_NOT
        );
    }
}
