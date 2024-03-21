<?php

namespace GrupoCometa\Validations\Generators;

class BindTypeColumnForTypeValidationHandler extends AbstractValidationRulesHandler
{
    private $bind = [
        'string' => 'string',
        'integer' => 'integer',
        'bigint' => 'numeric',
        'boolean' => 'boolean',
        'decimal' => 'numeric',
        'float' => 'numeric',
        'double' => 'numeric',
        'date' => 'date',
        'datetime' => 'date',
        'timestamp' => 'date',
        'time' => 'date',
        'year' => 'date',
        'enum' => 'in',
        'char' => 'string',
        'varchar' => 'string',
        'text' => 'string',
        'json' => 'array',
        'jsonb' => 'array',
        'array' => 'array',
        'email' => 'email',
    ];

    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        $type = $columnDetails->typeColumn();
        if (key_exists($type, $this->bind)) {

            $validation = $this->bind[$type];
            $rules->addRule($validation);

            return parent::handle($rules, $columnDetails);
        }

        $rules->addRule('nao possui bind');
        return parent::handle($rules, $columnDetails);
    }
}
