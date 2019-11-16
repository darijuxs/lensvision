<?php

namespace App\Entity\Request;

use App\Service\Serializer\NestedObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LenseOption
 *
 * @package App\Entity\Request
 */
class LenseOption implements NestedObjectInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 4,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string|null
     */
    private $option1;

    /**
     * @var string|null
     */
    private $option2;

    /**
     * @return string|null
     */
    public function getOption1(): ?string
    {
        return $this->option1;
    }

    /**
     * @param string|null $option1
     *
     * @return LenseOption
     */
    public function setOption1(?string $option1): LenseOption
    {
        $this->option1 = $option1;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOption2(): ?string
    {
        return $this->option2;
    }

    /**
     * @param string|null $option2
     *
     * @return LenseOption
     */
    public function setOption2(?string $option2): LenseOption
    {
        $this->option2 = $option2;

        return $this;
    }
}