<?php

namespace App\Service\Validator\Constraints;

use App\Consts\Option;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Class LenseOption
 *
 * @package App\Validator\Constraints
 *
 * @Annotation
 */
class LenseOption extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Value "{{ int }}" not found.';

    /**
     * @var int
     */
    protected $type;

    /**
     * LenseOption constructor.
     *
     * @param $options
     */
    public function __construct(array $options)
    {
        if (Option::TYPE_1 === $options['type'] || Option::TYPE_2 === $options['type']) {
            $this->type = $options['type'];
        } else {
            throw new MissingOptionsException('Type option is missing', $options);
        }

        parent::__construct($options);
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}