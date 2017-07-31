<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lakion\SyliusElasticSearchBundle\Form\Type;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use FOS\ElasticaBundle\Repository;
use Lakion\SyliusElasticSearchBundle\Search\Criteria\Filtering\ProductHasAttributeValuesFilter;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Query\ProductHasAttributeValueQueryFactory;
use Lakion\SyliusElasticSearchBundle\Search\Elastic\Factory\Search\SearchFactoryInterface;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\FiltersAggregation;
use ONGR\ElasticsearchDSL\Search;
use Sylius\Component\Attribute\AttributeType\TextAttributeType;
use Sylius\Component\Product\Model\ProductAttributeValue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AttributeValueFilterType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var RepositoryManagerInterface
     */
    private $repositoryManager;

    /**
     * @var ProductHasAttributeValueQueryFactory
     */
    private $productHasAttributeQueryFactory;

    /**
     * @var string
     */
    private $productModelClass;

    /**
     * @var SearchFactoryInterface
     */
    private $searchFactory;

    /**
     * @param RepositoryManagerInterface $repositoryManager
     * @param ProductHasAttributeValueQueryFactory $productHasAttributeQueryFactory
     * @param SearchFactoryInterface $searchFactory
     */
    public function __construct(
        RepositoryManagerInterface $repositoryManager,
        ProductHasAttributeValueQueryFactory $productHasAttributeQueryFactory,
        SearchFactoryInterface $searchFactory,
        $productModelClass
    ) {
        $this->repositoryManager = $repositoryManager;
        $this->productHasAttributeQueryFactory = $productHasAttributeQueryFactory;
        $this->searchFactory = $searchFactory;
        $this->productModelClass = $productModelClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', EntityType::class, [
            'class' => $options['class'],
            'label'=>false,
            'choice_value' => function ($productAttributeValueString) {
                return md5($productAttributeValueString);
            },
            'query_builder' => function (EntityRepository $repository) use ($options) {
                $queryBuilder = $repository->createQueryBuilder('o');

                return $queryBuilder
                    ->select(sprintf('DISTINCT o.%s', $options['attribute_value_field_type']))
                    ->leftJoin('o.attribute', 'attribute')
                    ->andWhere('attribute.code = :attributeCode')
                    ->setParameter('attributeCode', $options['attribute_code'])
                    ;
            },
            'choice_label' => function ($productAttributeValueString) use ($options) {

                $attributeCode = $options['attribute_code'];

                /** @var Repository $repository */
                $repository = $this->repositoryManager->getRepository($this->productModelClass);
                $query = $this->buildAggregation($attributeCode, $productAttributeValueString)->toArray();
                $result = $repository->createPaginatorAdapter($query);
                $aggregation = $result->getAggregations();
                $count = $aggregation[$attributeCode]['buckets'][$productAttributeValueString]['doc_count'];

                return sprintf('%s (%s)', $productAttributeValueString, $count);
            },
            'multiple' => true,
            'expanded' => true,
        ]);

        $builder->addModelTransformer($this);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (null  === $value) {
            return null;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($data)
    {
        if ($data['value'] instanceof Collection) {
            $productAttributeValues = $data['value']->map(function ($productAttributeValueString) {
                return $productAttributeValueString;
            });

            if ($productAttributeValues->isEmpty()) {
                return null;
            }

            return new ProductHasAttributeValuesFilter($productAttributeValues->toArray());
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('class', ProductAttributeValue::class)

            ->setRequired('attribute_code')
            ->setAllowedTypes('attribute_code', 'string')

            ->setDefault('attribute_value_field_type', TextAttributeType::TYPE)
            ->setAllowedTypes('attribute_value_field_type', 'string')
        ;
    }

    /**
     * @param string $value
     *
     * @return Search
     */
    private function buildAggregation($name, $value)
    {
        $hasAttributeValueAggregation = new FiltersAggregation($name);

        $hasAttributeValueAggregation->addFilter(
            $this->productHasAttributeQueryFactory->create(['attribute_value' => $value]),
            $value
        );

        $aggregationSearch = $this->searchFactory->create();
        $aggregationSearch->addAggregation($hasAttributeValueAggregation);

        return $aggregationSearch;
    }
}
