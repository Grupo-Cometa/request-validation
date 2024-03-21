<?php

namespace GrupoCometa\Validations\Generators;

class Validations
{
    private $items = [];

    public function addValidation(Rules $rules, ColumnDetails $columnDetails)
    {
        $this->items[$columnDetails->name()] = (string) $rules;
    }

    public function __toString()
    {
        $n = PHP_EOL;
        $strArr = var_export($this->items, true);
        $strArr =  str_replace(['array (', ')'], ['', ''], $strArr);
        $strArr = preg_replace('/\n|^/', "$n\t\t\t", $strArr);
        return $strArr;
    }
}
