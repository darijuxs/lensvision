<?php

namespace App\Service\Serializer\Normalizer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CollectionNormalizer
 *
 * @package App\Service\Serializer\Normalizer
 */
class CollectionNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var SerializerInterface|NormalizerInterface|DenormalizerInterface
     */
    protected $serializer;

    /**
     * @param SerializerInterface $serializer
     *
     * @throws InvalidArgumentException
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        if (!$serializer instanceof NormalizerInterface || !$serializer instanceof DenormalizerInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'Serializer must implement "%s" and "%s"',
                    'Symfony\Component\Serializer\Normalizer\NormalizerInterface',
                    'Symfony\Component\Serializer\Normalizer\DenormalizerInterface'
                )
            );
        }
        $this->serializer = $serializer;
    }

    /**
     * Returned normalized data
     *
     * @param Collection $object object to normalize
     * @param mixed      $format
     * @param array      $context
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $result = [];
        foreach ($object as $item) {
            $result[] = $this->serializer->normalize($item, $format, $context);
        }

        return $result;
    }

    /**
     * Returns collection of denormalized data
     *
     * @param mixed  $data
     * @param string $class
     * @param mixed  $format
     * @param array  $context
     *
     * @return ArrayCollection
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if ($this->serializer === null) {
            throw new BadMethodCallException('Please set a serializer before calling denormalize()!');
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException('Data expected to be an array, '.gettype($data).' given.');
        }
        if (substr($class, -2) !== '[]') {
            throw new InvalidArgumentException('Unsupported class: '.$class);
        }

        $itemType = substr($class, 0, -2);

        $result = new ArrayCollection();
        foreach ($data as $item) {
            $result->add($this->serializer->denormalize($item, $itemType, $format, $context));
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Collection;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return substr($type, -2) === '[]'
            && $this->serializer->supportsDenormalization($data, substr($type, 0, -2), $format);
    }
}
