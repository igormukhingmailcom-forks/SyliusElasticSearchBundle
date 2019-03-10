<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\Joining\HasChildQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

final class ProductFlagQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['flagName']) || null === $parameters['flagName']) {
            throw new MissingQueryParameterException('flagName', get_class($this));
        }

        return new TermQuery('flags', $parameters['flagName']);
    }
}
