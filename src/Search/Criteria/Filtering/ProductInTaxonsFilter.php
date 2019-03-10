<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering;

final class ProductInTaxonsFilter
{
    /**
     * @var array
     */
    private $taxonCodes;

    /**
     * @param array $taxonCodes
     */
    public function __construct(array $taxonCodes)
    {
        $this->taxonCodes = $taxonCodes;
    }

    /**
     * @return array
     */
    public function getTaxonCodes()
    {
        return $this->taxonCodes;
    }
}
