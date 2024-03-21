<?php

namespace GrupoCometa\Validations\Generators;


abstract class AbstractValidationRulesHandler
{
    private $nextHandler;

    public function nextHandler(AbstractValidationRulesHandler $handler = null)
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(Rules $rules, ColumnDetails $columnDetails)
    {
        if (!$this->nextHandler) return $rules;
        return $this->nextHandler->handle($rules, $columnDetails);
    }

    public function stop(Rules $rules): Rules
    {
        return $rules;
    }
}
