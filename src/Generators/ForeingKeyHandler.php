<?php

namespace GrupoCometa\Validations\Generators;

class ForeingKeyHandler extends AbstractValidationRulesHandler
{

    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        $foreignKey = $columnDetails->foreignKey();
        if (!$foreignKey) return parent::handle($rules, $columnDetails);

        $rules->addRule("exists:{$foreignKey->table},$foreignKey->column");

        return parent::handle($rules, $columnDetails);
    }
}
