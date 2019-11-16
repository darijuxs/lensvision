<?php

namespace App\Service\Serializer;

/**
 * Trait SerializerTrait
 *
 * @package App\Service\Serializer
 */
trait SerializerTrait
{
    /**
     * @param       $data
     * @param       $type
     * @param null  $format
     * @param array $context
     *
     * @return mixed
     */
    private function denormalize($data, $type, $format = null, array $context = [])
    {
        if ($this->has('serializer')) {
            return $this->get('serializer')->denormalize($data, $type, $format, $context);
        }

        throw new \RuntimeException('To enable helpers.serializer you must install the helpers.serializer component.');
    }

    /**
     * @param       $data
     * @param null  $format
     * @param array $context
     *
     * @return mixed
     */
    private function normalize($data, $format = null, array $context = [])
    {
        if ($this->has('serializer')) {
            return $this->get('serializer')->normalize($data, $format, $context);
        }

        throw new \RuntimeException('To enable helpers.serializer you must install the helpers.serializer component.');
    }
}