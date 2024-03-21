<?php

namespace GrupoCometa\Validations;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

abstract class Validation
{
    protected $request;
    
    public function handle($request, Closure $next)
    {
        $this->request = $request;
        $this->variablesResource();
        $this->validator();
        $this->authorization();
        return $next($request);
    }

    protected function variablesResource()
    {
        $attributes = @$this->request->route()[2] ?: [];
        $this->request->merge($attributes);
    }

    private function validator()
    {
        $validator = Validator::make(
            $this->request->all(),
            $this->rules(),
            $this->messages()
        );

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'type'   => 'warning',
                'message'   => 'Validation errors',
                'data'      => $validator->errors()
            ], 422));
        }
    }

    public function __get($name)
    {
        return $this->request->$name;
    }

    public function __call($name, $arguments)
    {
        $this->request->$name(...$arguments);
    }

    private function authorization()
    {
        if (!($this instanceof InterfaceAuthorization)) return true;

        if ($this->authorize()) return true;

        throw new HttpResponseException(response()->json([
            'type'   => 'warning',
            'message'   => 'validation.autorization',
        ], 401));
    }

    protected function messages(): array
    {
        return [];
    }

    abstract protected function rules(): array;
}
