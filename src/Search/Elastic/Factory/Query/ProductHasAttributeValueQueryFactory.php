<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query;

use Lakion\SyliusElasticSearchBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

final class ProductHasAttributeValueQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['attribute_value'])) {
            throw new MissingQueryParameterException('attribute_value', get_class($this));
        }

        if (is_array($parameters['attribute_value'])) {
            $childQuery = new BoolQuery();
            foreach ($parameters['attribute_value'] as $attributeValue) {
                $childQuery->add(
                    new TermQuery('attributes.value', $attributeValue),
                    BoolQuery::SHOULD
                );
            }
        } else {
            $childQuery = new TermQuery('attributes.value', $parameters['attribute_value']);
        }

        return new NestedQuery('attributes', $childQuery);

    }
}
