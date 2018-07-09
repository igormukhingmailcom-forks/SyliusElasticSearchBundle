<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering;

final class ProductIsPopularFilter
{
    /**
     * @var bool
     */
    private $isPopular;

    /**
     * ProductIsPopularFilter constructor.
     * @param $isPopular
     */
    public function __construct($isPopular)
    {
        $this->isPopular = $isPopular;
    }

    /**
     * @return string
     */
    public function isPopular()
    {
        return $this->isPopular;
    }
}
