<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ProductHasOptionCodeQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['option_value_code'])) {
            throw new MissingQueryParameterException('option_value_code', get_class($this));
        }

        if (is_array($parameters['option_value_code'])) {
            $childQuery = new BoolQuery();
            foreach ($parameters['option_value_code'] as $optionValueCode) {
                $childQuery->add(
                    new TermQuery('variants.optionValues.code', $optionValueCode),
                    BoolQuery::SHOULD
                );
            }
        } else {
            $childQuery = new TermQuery('variants.optionValues.code', $parameters['option_value_code']);
        }

        return
            new NestedQuery(
                'variants',
                new NestedQuery(
                    'variants.optionValues',
                    $childQuery
                )
            );
    }
}
