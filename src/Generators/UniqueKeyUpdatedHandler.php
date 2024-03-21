<?php

namespace GrupoCometa\Validations\Generators;

class UniqueKeyUpdatedHandler extends AbstractValidationRulesHandler
{
    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        if (!$columnDetails->uniqueKey())  return parent::handle($rules, $columnDetails);

        $id = '{$this->request->id}';
        $rules->addRule("unique:{$columnDetails->getTableName()},{$columnDetails->name()},$id");
        return parent::stop($rules);
    }
}
