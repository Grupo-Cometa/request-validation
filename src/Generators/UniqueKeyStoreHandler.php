<?php

namespace GrupoCometa\Validations\Generators;

class UniqueKeyStoreHandler extends AbstractValidationRulesHandler
{
    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        if (!$columnDetails->uniqueKey())  return parent::handle($rules, $columnDetails);
        
        $rules->addRule("unique:{$columnDetails->getTableName()},{$columnDetails->name()}");
        return parent::stop($rules);
    }
}
