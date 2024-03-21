<?php

namespace GrupoCometa\Validations\Generators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;

class FacadeGenerator
{
    private $namespace;
    private $tableName;

    public function __construct(private Model $model)
    {
        $this->tableName = $model->getTable();
        $this->setNamespace();
    }

    private function setNamespace()
    {
        $folder = ucfirst($this->tableName);
        $this->namespace = "App\\Http\\Middleware\\Validations\\$folder";
    }

    private function getClassShortName()
    {
        $reflection = new ReflectionClass($this->model);
        return $reflection->getShortName();
    }

    public function validationStore()
    {
        $columns = Schema::getColumnListing($this->tableName);

        $validations = new Validations;
        foreach ($columns as  $columnName) {
            $columnDetails = new ColumnDetails($this->tableName, $columnName);

            $rules = new Rules();

            $handler = new AutoIncrementHandler;
            $handler->nextHandler(new RequiredHandler)
                ->nextHandler(new BindTypeColumnForTypeValidationHandler)
                ->nextHandler(new UniqueKeyStoreHandler)
                ->nextHandler(new MaxLengthHandler)
                ->nextHandler(new ForeingKeyHandler);

            $rules = $handler->handle($rules, $columnDetails);

            $validations->addValidation($rules, $columnDetails);
        }

        $className = "{$this->getClassShortName()}StoreValidation";
        $createFile = new CreateFile($validations, $this->namespace, $className);

        $createFile->save();
    }


    public function validationUpdate()
    {
        $columns = Schema::getColumnListing($this->tableName);

        $validations = new Validations;
        foreach ($columns as  $columnName) {
            $columnDetails = new ColumnDetails($this->tableName, $columnName);

            $rules = new Rules();

            $handler = new AutoIncrementHandler;
            $handler->nextHandler(new BindTypeColumnForTypeValidationHandler)
                ->nextHandler(new UniqueKeyUpdatedHandler)
                ->nextHandler(new MaxLengthHandler)
                ->nextHandler(new ForeingKeyHandler);

            $rules = $handler->handle($rules, $columnDetails);

            $validations->addValidation($rules, $columnDetails);
        }

        $className = "{$this->getClassShortName()}UpdateValidation";
        $createFile = new CreateFile($validations, $this->namespace, $className);

        $createFile->save();
    }
}
