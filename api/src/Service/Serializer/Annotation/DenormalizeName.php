<?php

namespace App\Service\Serializer\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class DenormalizeName
 *
 * @package App\Service\Serializer\Annotation
 *
 * @Annotation
 */
class DenormalizeName
{
    /**
     * @var string
     */
    protected $name;

    /**
     * DenormalizeName constructor.
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
