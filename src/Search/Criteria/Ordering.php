<?php

namespace Lakion\SyliusElasticSearchBundle\Search\Criteria;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class Ordering
{
    const DEFAULT_DIRECTION = self::DESCENDING_DIRECTION;
    const ASCENDING_DIRECTION = 'asc';
    const DESCENDING_DIRECTION = 'desc';

    /**
     * @var string
     */
    private $sortFields;

    /**
     * Ordering constructor.
     * @param $sortFields
     */
    private function __construct($sortFields)
    {
        $this->sortFields = $sortFields;
    }

    /**
     * @param array $parameters
     *
     * @return Ordering
     */
    public static function fromQueryParameters(array $parameters)
    {
        $sortFields = [
            'prettyRank' => self::DEFAULT_DIRECTION,
        ];

        if (isset($parameters['sort'])) {
            $sortFields = $parameters['sort'];
        }

        foreach ($sortFields as $sortField=>$sortDirection) {
            if (!in_array($sortDirection, [self::ASCENDING_DIRECTION, self::DESCENDING_DIRECTION])) {
                throw new BadRequestHttpException(sprintf(
                    'Unexpected sort order %s for field %s. Expecting one of %s',
                    $sortDirection,
                    $sortField,
                    join(',', [self::ASCENDING_DIRECTION, self::DESCENDING_DIRECTION])
                ));
            }
        }

        return new self($sortFields);
    }

    /**
     * @return string
     */
    public function getSortFields()
    {
        return $this->sortFields;
    }
}
