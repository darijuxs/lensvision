<?php

namespace App\Service\Validator\Constraints;

use App\Consts\Option;
use App\Entity\Database\LenseOption as LenseOptionDatabase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class LenseOptionValidator
 *
 * @package App\Validator\Constraints
 */
class LenseOptionValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * LenseOptionValidator constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed $lenseOptionId
     * @param Constraint $constraint
     */
    public function validate($lenseOptionId, Constraint $constraint)
    {
        if (null === $lenseOptionId || '' === $lenseOptionId) {
            return;
        }

        $lenseOption = $this->em
            ->getRepository(LenseOptionDatabase::class)
            ->getOne($lenseOptionId);

        $types = Option::DATA[$constraint->getType()];

        /* @var LenseOptionDatabase $lenseOption */
        if (!$lenseOption || !in_array($lenseOption->getType(), $types, true)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ int }}', $lenseOptionId)
                ->addViolation();
        }
    }
}