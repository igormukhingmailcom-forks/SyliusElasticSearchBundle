<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Filter;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductHasAttributeValuesFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\ProductHasAttributeValueQueryFactory;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

final class ProductHasMultipleAttributeValuesApplicator extends SearchCriteriaApplicator
{
    /**
     * @var ProductHasAttributeValueQueryFactory
     */
    private $productHasAttributeValueQueryFactory;

    /**
     * {@inheritdoc}
     */
    public function __construct(ProductHasAttributeValueQueryFactory $productHasAttributeValueQueryFactory)
    {
        $this->productHasAttributeValueQueryFactory = $productHasAttributeValueQueryFactory;
    }

    /**
     * @param ProductHasAttributeValuesFilter $valuesFilter
     * @param Search $search
     */
    public function applyProductHasAttributeValuesFilter(ProductHasAttributeValuesFilter $valuesFilter, Search $search)
    {
        $search->addFilter(
            $this->productHasAttributeValueQueryFactory->create([
                'attribute_value' => $valuesFilter->getValues()
            ]),
            BoolQuery::MUST
        );
    }
}
