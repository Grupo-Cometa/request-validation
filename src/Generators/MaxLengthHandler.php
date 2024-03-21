<?php

namespace GrupoCometa\Validations\Generators;

class MaxLengthHandler extends AbstractValidationRulesHandler
{

    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        $max = $columnDetails->maxLength();
        if (!$max || !$rules->exitsRules('string')) return parent::handle($rules, $columnDetails);
 
        $rules->addRule("max:{$max}");

        return parent::handle($rules, $columnDetails);
    }
}
