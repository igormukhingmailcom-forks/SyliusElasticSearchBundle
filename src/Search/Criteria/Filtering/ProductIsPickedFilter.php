<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering;

final class ProductIsPickedFilter
{
    /**
     * @var bool
     */
    private $isPicked;

    /**
     * ProductIsPickedFilter constructor.
     * @param bool $isPicked
     */
    public function __construct(bool $isPicked)
    {
        $this->isPicked = $isPicked;
    }

    /**
     * @return string
     */
    public function isPicked()
    {
        return $this->isPicked;
    }
}
