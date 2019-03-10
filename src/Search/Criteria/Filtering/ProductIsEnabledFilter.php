<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering;

final class ProductIsEnabledFilter
{
    /**
     * @var bool
     */
    private $isEnabled;

    /**
     * ProductIsEnabledFilter constructor.
     * @param $isEnabled
     */
    public function __construct($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return string
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }
}
