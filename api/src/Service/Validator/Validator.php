<?php

namespace App\Service\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Validator
 *
 * @package App\Service\Validator
 */
class Validator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ConstraintViolationListInterface
     */
    private $errors;

    /**
     * Validator constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function validate($data): bool
    {
        $errors = $this->validator->validate($data);
        if ($errors->count() === 0) {
            return true;
        }

        $this->errors = $errors;

        return false;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->errors as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->errors->count() === 0;
    }
}