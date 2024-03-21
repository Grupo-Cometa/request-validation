<?php

namespace GrupoCometa\Validations\Generators;

class RequiredHandler extends AbstractValidationRulesHandler
{

    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        if (!$columnDetails->notNull()) return parent::handle($rules, $columnDetails);

        $rules->addRule('required');

        return parent::handle($rules, $columnDetails);
    }
}
