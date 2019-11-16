<?php

namespace App\Entity\Database;

use App\Service\Serializer\Normalizer\NestedObjectNormalizer;

/**
 * Class LenseOption
 *
 * @package App\Entity\Database
 */
class LenseOption
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $type;
}