<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Filter;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductInTaxonFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ProductInTaxonApplicator extends SearchCriteriaApplicator
{
    /**
     * @var QueryFactoryInterface
     */
    private $productInMainTaxonQueryFactory;

    /**
     * @var QueryFactoryInterface
     */
    private $productInProductTaxonsQueryFactory;

    /**
     * @param QueryFactoryInterface $productInMainTaxonQueryFactory
     * @param QueryFactoryInterface $productInProductTaxonsQueryFactory
     */
    public function __construct(
        QueryFactoryInterface $productInMainTaxonQueryFactory,
        QueryFactoryInterface $productInProductTaxonsQueryFactory
    ) {
        $this->productInMainTaxonQueryFactory = $productInMainTaxonQueryFactory;
        $this->productInProductTaxonsQueryFactory = $productInProductTaxonsQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function applyProductInTaxonFilter(ProductInTaxonFilter $inTaxonFilter, Search $search)
    {
        $childQuery = new BoolQuery();
        $childQuery->add(
            $this->productInMainTaxonQueryFactory->create([
                'taxon_code' => $inTaxonFilter->getTaxonCode()
            ]),
            BoolQuery::SHOULD
        );
        $childQuery->add(
            $this->productInProductTaxonsQueryFactory->create([
                'taxon_code' => $inTaxonFilter->getTaxonCode()
            ]),
            BoolQuery::SHOULD
        );

        $search->addFilter(
            $childQuery,
            BoolQuery::MUST
        );
    }
}
