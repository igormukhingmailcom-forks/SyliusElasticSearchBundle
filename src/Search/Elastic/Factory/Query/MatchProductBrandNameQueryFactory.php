<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;

final class MatchProductBrandNameQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['phrase']) || null == $parameters['phrase']) {
            throw new MissingQueryParameterException('phrase', get_class($this));
        }

        return new MatchQuery('brandName', $parameters['phrase']);
    }
}
