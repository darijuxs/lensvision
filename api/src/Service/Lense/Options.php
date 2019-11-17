<?php

namespace App\Service\Lense;

use App\Entity\Request\LenseOption;
use App\Entity\Database\LenseOption as LenseOptionDatabase;
use Doctrine\ORM\EntityManager;

/**
 * Class Options
 *
 * @package App\Service\Lense
 */
class Options
{
    /**
     * @var EntityManager;
     */
    private $em;

    /**
     * @var OptionRules
     */
    private $optionRules;

    /**
     * Options constructor.
     *
     * @param EntityManager $em
     * @param OptionRules $optionRules
     */
    public function __construct(EntityManager $em, OptionRules $optionRules)
    {
        $this->em = $em;
        $this->optionRules = $optionRules;
    }

    /**
     * @param LenseOption $lenseOptionRequest
     *
     * @return array
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getGroupedValues(LenseOption $lenseOptionRequest): array
    {
        $lenseOptions = $this->getValues($lenseOptionRequest);

        $groupedValues = [];
        foreach ($lenseOptions as $lenseOption) {
            $groupedValues[$lenseOption->getType()][$lenseOption->getId()] = $lenseOption;
        }

        return $groupedValues;
    }

    /**
     * @param LenseOption $lenseOptionRequest
     *
     * @return LenseOptionDatabase[]
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getValues(LenseOption $lenseOptionRequest): array
    {
        $availableOptionTypes = $this->getAvailableTypes($lenseOptionRequest);

        $lenseOptions = $this->em
            ->getRepository(LenseOptionDatabase::class)
            ->getAllByTypes($availableOptionTypes);

        return $lenseOptions;
    }

    /**
     * @param LenseOption $lenseOptionRequest
     *
     * @return array
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getAvailableTypes(LenseOption $lenseOptionRequest): array
    {
        $type1 = null;
        $type2 = null;

        if ($lenseOptionRequest->getParameter1()) {
            $lenseOption = $this->em
                ->getRepository(LenseOptionDatabase::class)
                ->getOne($lenseOptionRequest->getParameter1());

            $type1 = $lenseOption ? $lenseOption->getType() : null;
        }

        if ($lenseOptionRequest->getParameter2()) {
            $lenseOption = $this->em
                ->getRepository(LenseOptionDatabase::class)
                ->getOne($lenseOptionRequest->getParameter2());

            $type2 = $lenseOption ? $lenseOption->getType() : null;
        }

        $availableOptionTypes = $this->optionRules->getAvailableTypes($type1, $type2);

        return $availableOptionTypes;
    }
}