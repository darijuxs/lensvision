<?php

namespace App\Service\Serializer\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class NormalizeName
 *
 * @package App\Service\Serializer\Annotation
 *
 * @Annotation
 */
class NormalizeName
{
    /**
     * @var string
     */
    protected $name;

    /**
     * NormalizeName constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (!empty($data['value'])) {
            $this->name = $data['value'];
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}