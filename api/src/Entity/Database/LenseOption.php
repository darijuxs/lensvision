<?php

namespace App\Entity\Database;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LenseOptionRepository")
 * @ORM\Table(
 *     name="lense_option",
 *     indexes={
 *          @ORM\Index(name="type", columns={"type"})
 *      }
 * )
 */
class LenseOption
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     *
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $value;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return LenseOption
     */
    public function setId(int $id): LenseOption
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return LenseOption
     */
    public function setType(string $type): LenseOption
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return LenseOption
     */
    public function setValue(string $value): LenseOption
    {
        $this->value = $value;

        return $this;
    }
}