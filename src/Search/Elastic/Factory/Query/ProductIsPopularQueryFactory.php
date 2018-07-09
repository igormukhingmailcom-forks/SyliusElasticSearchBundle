<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

final class ProductIsPopularQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['popular'])) {
            throw new MissingQueryParameterException('popular', get_class($this));
        }

        return new TermQuery('popular', $parameters['popular']);
    }
}
