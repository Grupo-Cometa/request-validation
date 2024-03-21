<?php

namespace GrupoCometa\Validations\Generators;

class ForeingKey {
    public function __construct(public $table, public $column)
    {
        
    }
}