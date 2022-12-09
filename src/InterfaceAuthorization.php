<?php

namespace GrupoCometa\Request;

interface InterfaceAuthorization 
{
    public function authorize(): bool;
}