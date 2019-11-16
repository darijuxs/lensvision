<?php

namespace App\Service\Validator;

/**
 * Trait ValidatorTrait
 *
 * @package App\Service\Validator
 */
trait ValidatorTrait
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @param $data
     *
     * @return bool
     */
    public function validate($data): bool
    {
        if (!$this->has(Validator::class)) {
            throw new \RuntimeException('To enable validator you must install the helpers.validator component.');
        }

        $this->validator = $this->get(Validator::class);

        return $this->validator->validate($data);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        if ($this->validator instanceof Validator) {
            return $this->validator->getErrors();
        }

        return [];
    }
}