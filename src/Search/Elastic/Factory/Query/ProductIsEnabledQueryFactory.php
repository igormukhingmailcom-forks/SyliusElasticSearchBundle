<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

final class ProductIsEnabledQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['enabled'])) {
            throw new MissingQueryParameterException('enabled', get_class($this));
        }

        return new TermQuery('enabled', $parameters['enabled']);
    }
}
