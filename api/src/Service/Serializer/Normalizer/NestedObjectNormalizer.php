<?php

namespace App\Service\Serializer\Normalizer;

use App\Service\Serializer\Annotation\NormalizeName;
use App\Service\Serializer\Annotation\DenormalizeName;
use App\Service\Serializer\NestedObjectInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class NestedObjectNormalizer
 *
 * @package App\Service\Serializer\Normalizer
 */
class NestedObjectNormalizer extends ObjectNormalizer
{
    /**
     * @var null|PropertyTypeExtractorInterface
     */
    private $propertyTypeExtractor;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var bool
     */
    private $useTypeCasting = true;

    /**
     * NestedObjectNormalizer constructor.
     *
     * @param ClassMetadataFactoryInterface|null  $classMetadataFactory
     * @param NameConverterInterface|null         $nameConverter
     * @param PropertyAccessorInterface|null      $propertyAccessor
     * @param PropertyTypeExtractorInterface|null $propertyTypeExtractor
     */
    public function __construct(
        ClassMetadataFactoryInterface $classMetadataFactory = null,
        NameConverterInterface $nameConverter = null,
        PropertyAccessorInterface $propertyAccessor = null,
        PropertyTypeExtractorInterface $propertyTypeExtractor = null
    ) {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor);

        $this->propertyTypeExtractor = $propertyTypeExtractor;
    }

    /**
     * @param AnnotationReader $annotationReader
     */
    public function setAnnotationReader(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && !$data instanceof \Traversable && is_subclass_of($data, NestedObjectInterface::class);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        $dd = is_subclass_of($type, NestedObjectInterface::class);
        return class_exists($type) && $dd;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        foreach ((new \ReflectionClass($class))->getProperties() as $property) {
            /** @var DenormalizeName $result */
            $result = $this->annotationReader->getPropertyAnnotation($property, DenormalizeName::class);
            if ($result) {
                $propertyName = $result->getName();
                if (!empty($propertyName) && isset($data[$propertyName])) {
                    $data[$property->getName()] = $data[$propertyName];
                    unset($data[$propertyName]);
                }
            }
        }

        if (isset($context['entity_object_use_type_casting'])) {
            $this->useTypeCasting = (bool)$context['entity_object_use_type_casting'];
            unset($context['entity_object_use_type_casting']);
        }

        if ($this->useTypeCasting) {
            $data = $this->prepareForDenormalization($data);
            foreach ($data as $attribute => &$value) {
                if ($this->nameConverter) {
                    $attribute = $this->nameConverter->denormalize($attribute);
                }
                $types = $this->propertyTypeExtractor->getTypes($class, $attribute);
                if (count((array)$types) === 1) {
                    $builtinType = $types[0]->getBuiltinType();
                    if (
                        Type::BUILTIN_TYPE_OBJECT !== $builtinType &&
                        function_exists('is_' . $builtinType) &&
                        !call_user_func('is_' . $builtinType, $value) &&
                        !($types[0]->isNullable() && $value === null)
                    ) {
                        settype($value, $builtinType);
                    }
                }
            }
        }

        return parent::denormalize($data, $class, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = parent::normalize($object, $format, $context);
        foreach ((new \ReflectionClass(get_class($object)))->getProperties() as $property) {
            $result = $this->annotationReader->getPropertyAnnotation($property, NormalizeName::class);
            if (!empty($result)) {
                $data[$result->getName()] = $data[$this->nameConverter->normalize($property->getName())];
                unset($data[$this->nameConverter->normalize($property->getName())]);
            }

        }

        return $data;
    }
}
