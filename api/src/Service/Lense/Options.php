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
     * @var OptionRules2
     */
    private $optionRules2;

    /**
     * @var int
     */
    private $version;

    /**
     * Options constructor.
     *
     * @param EntityManager $em
     * @param OptionRules $optionRules
     * @param OptionRules2 $optionRules2
     */
    public function __construct(EntityManager $em, OptionRules $optionRules, OptionRules2 $optionRules2)
    {
        $this->em = $em;
        $this->optionRules = $optionRules;
        $this->optionRules2 = $optionRules2;
    }

    /**
     * @param int $version
     *
     * @return Options
     */
    public function setVersion(int $version): Options
    {
        $this->version = $version;

        return $this;
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

        //@todo create factory
        switch ($this->version) {
            case 2:
                $availableOptionTypes = $this->optionRules2->getAvailableTypes($type1, $type2);
                break;

            default:
                $availableOptionTypes = $this->optionRules->getAvailableTypes($type1, $type2);
                break;
        }

        return $availableOptionTypes;
    }
}