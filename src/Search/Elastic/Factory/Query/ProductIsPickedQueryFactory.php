<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

final class ProductIsPickedQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['picked'])) {
            throw new MissingQueryParameterException('picked', get_class($this));
        }

        return new TermQuery('picked', $parameters['picked']);
    }
}
