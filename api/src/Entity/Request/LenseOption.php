<?php

namespace App\Entity\Request;

use App\Service\Serializer\NestedObjectInterface;
use App\Service\Validator\Constraints as CustomAssert;
use App\Consts\Option;

/**
 * Class LenseOption
 *
 * @package App\Entity\Request
 */
class LenseOption implements NestedObjectInterface
{
    /**
     * @CustomAssert\LenseOption(
     *     type=Option::TYPE_1,
     *     message="First parameter value not found",
     * )
     *
     * @var int|null
     */
    private $parameter1;

    /**
     * @CustomAssert\LenseOption(
     *     type=Option::TYPE_2,
     *     message="Second parameter value not found",
     * )
     *
     * @var int|null
     */
    private $parameter2;

    /**
     * @return int|null
     */
    public function getParameter1(): ?int
    {
        return $this->parameter1;
    }

    /**
     * @param int|null $parameter1
     *
     * @return LenseOption
     */
    public function setParameter1(?int $parameter1): LenseOption
    {
        $this->parameter1 = $parameter1;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getParameter2(): ?int
    {
        return $this->parameter2;
    }

    /**
     * @param int|null $parameter2
     *
     * @return LenseOption
     */
    public function setParameter2(?int $parameter2): LenseOption
    {
        $this->parameter2 = $parameter2;

        return $this;
    }
}