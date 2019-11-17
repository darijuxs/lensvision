<?php

namespace App\Service\Lense;

use App\Consts\Option;

/**
 * Class OptionRules2
 *
 * @package App\Service\Lense
 */
class OptionRules2
{
    const DATA = [
        Option::TYPE_1 =>
            [
                'A' => [
                    'X',
                    'Z',
                ],
                'B' => [
                    'X',
                    'Y',
                    'Z',
                ],
                'C' => [
                    'X',
                    'Y',
                ],
            ],
        Option::TYPE_2 => [
            'X' => [
                'A',
                'B',
                'C',
            ],
            'Y' => [
                'B',
                'C',
            ],
            'Z' => [
                'A',
                'B',
            ],
        ],
    ];


    /**
     * @param string|null $type1
     * @param string|null $type2
     *
     * @return array
     */
    public function getAvailableTypes(string $type1 = null, string $type2 = null): array
    {
        $options2 = $type1 ? self::DATA[Option::TYPE_1][$type1] ?? [] : Option::DATA[Option::TYPE_2];
        $options1 = $type2 ? self::DATA[Option::TYPE_2][$type2] ?? [] : Option::DATA[Option::TYPE_1];

        $options1 = $type1 ? [$type1] : $options1;
        $options2 = $type2 ? [$type2] : $options2;

        return array_unique(array_merge($options1, $options2));
    }
}