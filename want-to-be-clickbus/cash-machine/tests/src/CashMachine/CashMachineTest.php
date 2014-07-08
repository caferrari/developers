<?php

namespace ClickBus\CashMachine;

class CashMachineTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerForValidWithdraws
     */
    public function testWithdrawWithValidAmounts($amount, $expected)
    {
        $notes = (new CashMachine)->withdraw($amount);
        $this->assertEquals($expected, $notes);
    }

    /**
     * @dataProvider providerForInvalidNotesWithdraws
     * @expectedException ClickBus\CashMachine\NoteUnavailableException
     */
    public function testWithdrawWithoutTheNecessaryNotes($amount)
    {
        (new CashMachine)->withdraw($amount);
    }

    /**
     * @dataProvider providerForInvalidAmounts
     * @expectedException InvalidArgumentException
     */
    public function testWithdrawWithInvalidAmouts($amount)
    {
        (new CashMachine)->withdraw($amount);
    }

    public function providerForValidWithdraws()
    {
        return array(
            [null, []],
            [10, [10]],
            [20, [20]],
            [30, [20, 10]],
            [40, [20, 20]],
            [50, [50]],
            [60, [50, 10]],
            [70, [50, 20]],
            [80, [50, 20, 10]],
            [90, [50, 20, 20]],
            [100, [100]],
            [150, [100, 50]],
            [160, [100, 50, 10]],
            [170, [100, 50, 20]],
            [180, [100, 50, 20, 10]],
            [190, [100, 50, 20, 20]],
            [200, [100, 100]],
            [280, [100, 100, 50, 20, 10]]
        );
    }

    public function providerForInvalidNotesWithdraws()
    {
        return array(
            [5],
            [11],
            [3],
            [1],
            [1955],
            [126]
        );
    }

    public function providerForInvalidAmounts()
    {
        return array(
            [0],
            [-11],
            [-3],
            [-1],
            [-1955],
            [-126]
        );
    }
}
