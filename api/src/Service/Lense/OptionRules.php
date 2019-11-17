<?php

namespace App\Service\Lense;

use App\Consts\Option;

/**
 * Class OptionRules
 *
 * @package App\Service\Lense
 */
class OptionRules
{
    const FORBIDDEN_RULES = [
        'AY',
        'CZ',
    ];

    /**
     * @param string|null $type1
     * @param string|null $type2
     *
     * @return array
     */
    public function getAvailableTypes(string $type1 = null, string $type2 = null): array
    {
        $options1 = $this->getData(Option::TYPE_1, $type1);
        $options2 = $this->getData(Option::TYPE_2, $type2);

        $availableTypesValues = [];

        foreach ($options1 as $option1) {
            foreach ($options2 as $option2) {
                if (in_array($option1 . $option2, self::FORBIDDEN_RULES, true)) {
                    continue;
                }

                $availableTypesValues[] = $option2;
                $availableTypesValues[] = $option1;
            }

        }

        return array_unique($availableTypesValues);
    }

    /**
     * @param int $type
     * @param string|null $typeValue
     *
     * @return array
     */
    private function getData(int $type, string $typeValue = null): array
    {
        if (isset(Option::DATA[$type])) {
            $key = array_search($typeValue, Option::DATA[$type], true);
            if (false !== $key) {
                return [
                    Option::DATA[$type][$key]
                ];
            }

            return Option::DATA[$type];
        }

        return [];
    }
}
