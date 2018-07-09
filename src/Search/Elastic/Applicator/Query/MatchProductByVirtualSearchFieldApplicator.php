<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\Query;

use Lakion\SyliusElasticSearchBundle\Search\Criteria\SearchPhrase;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Applicator\SearchCriteriaApplicator;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Search;

final class MatchProductByVirtualSearchFieldApplicator extends SearchCriteriaApplicator
{
    /**
     * @var QueryFactoryInterface
     */
    private $matchProductVirtualSearchFieldQueryFactory;

    /**
     * @var QueryFactoryInterface
     */
    private $emptyCriteriaQueryFactory;

    /**
     * @param QueryFactoryInterface $matchProductVirtualSearchFieldQueryFactory
     * @param QueryFactoryInterface $emptyCriteriaQueryFactory
     */
    public function __construct(
        QueryFactoryInterface $matchProductVirtualSearchFieldQueryFactory,
        QueryFactoryInterface $emptyCriteriaQueryFactory
    ) {
        $this->matchProductVirtualSearchFieldQueryFactory = $matchProductVirtualSearchFieldQueryFactory;
        $this->emptyCriteriaQueryFactory = $emptyCriteriaQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function applySearchPhrase(SearchPhrase $searchPhrase, Search $search)
    {
        if (null != $searchPhrase->getPhrase()) {
            $search->addQuery($this->matchProductVirtualSearchFieldQueryFactory->create(['phrase' => $searchPhrase->getPhrase()]));

            return;
        }

        $search->addQuery($this->emptyCriteriaQueryFactory->create());
    }
}
