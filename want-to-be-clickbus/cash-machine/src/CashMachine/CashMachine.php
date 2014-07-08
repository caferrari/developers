<?php

namespace ClickBus\CashMachine;

use \InvalidArgumentException;

class CashMachine
{

    protected $availableNotes = [100, 50, 20, 10];

    public function withdraw($amount)
    {

        if (is_null($amount)) {
            return [];
        }

        if ($amount <= 0) {
            throw new InvalidArgumentException('You can\'t withdraw that value');
        }

        $residual = $amount;
        $notes = [];

        foreach ($this->availableNotes as $note) {
            while ($residual >= $note) {
                $notes[] = $note;
                $residual -= $note;
            }
        }

        if ($residual > 0) {
            throw new NoteUnavailableException('We dont have the necessary notes for your withdraw');
        }

        return $notes;
    }
}
