<?php

namespace ClickBus\Pooler;

class PoolerTest extends \PHPUnit_Framework_TestCase
{

    public function testSort()
    {
        $pooler = new Pooler(1);

        $reflectedClass = new \ReflectionClass("\ClickBus\Pooler\Pooler");
        $method = $reflectedClass->getMethod("sort");
        $method->setAccessible(true);

        $sorted = $method->invoke($pooler, [5, 1, -10, 8, 9, -15]);

        $this->assertEquals([-15, -10, 1, 5, 8, 9], $sorted);
    }

    /**
    * @dataProvider providerForRoundDownNumbers
    */
    public function testRoundDown($number, $base, $expected)
    {
        $pooler = new Pooler(1);

        $reflectedClass = new \ReflectionClass("\ClickBus\Pooler\Pooler");
        $method = $reflectedClass->getMethod("roundDown");
        $method->setAccessible(true);

        $this->assertEquals($expected, $method->invoke($pooler, $number, $base));
    }

    /**
    * @dataProvider providerForValidRangesAndSets
    */
    public function testPoolerWithValidRangeAndSets($range, $set, $expected)
    {
        $groups = (new Pooler($range))->group($set);
        $this->assertEquals($expected, $groups);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPoolerWithInvalidNumbersInsideTheSet()
    {
        $set = [10, 1, 'A',  14, 99, 133, 19, 20, 117, 22, 93,  120, 131];
        (new Pooler(15))->group($set);
    }

    public function providerForValidRangesAndSets()
    {

        return array(
            [10, [10, 1, -20, 14, 99, 136, 19, 20, 117, 22, 93, 120, 131], [[-20], [1, 10], [14, 19, 20], [22], [93, 99], [117, 120], [131, 136]]],
            [15, [10, 1, -20, 14, 99, 136, 19, 20, 117, 22, 93, 120, 131], [[-20], [1, 10, 14], [19, 20, 22], [93, 99], [117, 120], [131], [136]]],
            [10, [], []],
            [null, [], []]
        );

    }

    public function providerForRoundDownNumbers()
    {
        return array(
            [-20, 10, -20],
            [-15, 10, -10],
            [15, 10, 20],
            [35, 10, 40]
        );
    }
}
