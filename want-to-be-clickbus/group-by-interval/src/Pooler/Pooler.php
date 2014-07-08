<?php

namespace ClickBus\Pooler;

use \InvalidArgumentException;

class Pooler
{

    private $range;

    public function __construct($range)
    {
        $this->range = $range;
    }

    public function group(array $set)
    {
        $this->validateSet($set);
        $set = $this->sort($set);
        $pool = array();

        foreach ($set as $number) {
            $currentRange = $this->roundDown($number, $this->range);
            $pool[$currentRange][] = $number;
        }

        return array_values($pool);
    }

    private function validateSet(array $set)
    {
        array_walk($set, function ($number) {
            if (!is_numeric($number)) {
                throw new InvalidArgumentException('Only numbers are allowed in the set');
            }
        });
    }

    private function sort(array $set)
    {
        $length = count($set);
        for ($i=0; $i < $length; $i++) {
            for ($j = $i+1; $j < $length; $j++) {
                if ($set[$i] > $set[$j]) {
                    $aux = $set[$i];
                    $set[$i] = $set[$j];
                    $set[$j] = $aux;
                }
            }
        }
        return $set;
    }

    private function roundDown($number, $multiple)
    {
        return (integer)(ceil($number / $multiple)) * $multiple;
    }
}
