<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class MatchProductDescriptionQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['phrase']) || null == $parameters['phrase']) {
            throw new MissingQueryParameterException('search', get_class($this));
        }

        return new NestedQuery(
            'translations',
            new MatchQuery('translations.description', $parameters['phrase'])
        );
    }
}
