<?php

namespace GrupoCometa\Validations\Generators;

use JsonSerializable;

class Rules implements JsonSerializable
{
    private $items = [];

    public function addRule(mixed $validation)
    {
        $this->items[] = $validation;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function exitsRules(string $rule): bool
    {
        return in_array($rule, $this->items);
    }

    public function __toString()
    {
        $strValidation = implode("|", $this->items);
        return $strValidation;
    }

    public function jsonSerialize()
    {
        return implode("|", $this->items);
    }
}
