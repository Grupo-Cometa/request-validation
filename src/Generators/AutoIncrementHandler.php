<?php

namespace GrupoCometa\Validations\Generators;

class AutoIncrementHandler extends AbstractValidationRulesHandler
{

    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        if (!$columnDetails->autoIncrement())  return parent::handle($rules, $columnDetails);

        $rules->addRule("prohibited");
        return parent::stop($rules);
    }
}
