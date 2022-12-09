<?php

namespace Cometa\Request;

interface InterfaceAuthorization 
{
    public function authorize(): bool;
}