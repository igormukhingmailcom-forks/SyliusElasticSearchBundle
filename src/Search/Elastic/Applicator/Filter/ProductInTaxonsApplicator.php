<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Filter;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductInTaxonsFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

final class ProductInTaxonsApplicator extends SearchCriteriaApplicator
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
    public function applyProductInTaxonsFilter(ProductInTaxonsFilter $inTaxonsFilter, Search $search)
    {
        $childQuery = new BoolQuery();

        foreach ($inTaxonsFilter->getTaxonCodes() as $taxonCode) {
            $childQuery->add(
                $this->productInMainTaxonQueryFactory->create([
                    'taxon_code' => $taxonCode
                ]),
                BoolQuery::SHOULD
            );
            $childQuery->add(
                $this->productInProductTaxonsQueryFactory->create([
                    'taxon_code' => $taxonCode
                ]),
                BoolQuery::SHOULD
            );
        }

        $search->addFilter(
            $childQuery,
            BoolQuery::MUST
        );
    }
}
