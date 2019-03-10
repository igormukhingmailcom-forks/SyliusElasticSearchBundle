<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering;

final class ProductFlagFilter
{
    /**
     * @var string
     */
    private $flagName;

    /**
     * @var bool
     */
    private $flagValue;

    /**
     * ProductFlagFilter constructor.
     * @param $flagName
     * @param $flagValue
     */
    public function __construct($flagName, $flagValue)
    {
        $this->flagName = $flagName;
        $this->flagValue = $flagValue;
    }

    /**
     * @return string
     */
    public function flagName()
    {
        return $this->flagName;
    }

    /**
     * @return bool
     */
    public function flagValue()
    {
        return $this->flagValue;
    }
}
