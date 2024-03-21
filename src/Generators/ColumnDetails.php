<?php

namespace GrupoCometa\Validations\Generators;

use Illuminate\Support\Facades\Schema;

class ColumnDetails
{

    private $connection;
    private $columnDetails;
    private $name;
    private $tableDetails;

    public function __construct(private $tableName, $columnName)
    {
        $this->name = $columnName;
        $this->connection = Schema::getConnection();
        $this->columnDetails = $this->connection->getDoctrineColumn($tableName, $columnName);
        $this->tableDetails = $this->connection->getDoctrineSchemaManager();
    }

    public function name()
    {
        return $this->name;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function autoIncrement(): bool
    {
        return $this->columnDetails->getAutoincrement();
    }

    public function maxLength()
    {
        return $this->columnDetails->getLength();
    }

    public function typeColumn()
    {
        return $this->columnDetails->getType()->getName();
    }

    public function notNull()
    {
        return $this->columnDetails->getNotnull();
    }

    public function scale()
    {
        return $this->columnDetails->getScale();
    }


    public function primaryKey(): bool
    {
        $primarys = $this->tableDetails->introspectTable($this->tableName)->getPrimaryKey();
        $columns = $primarys->getColumns();
        if (count($columns) == 1 && $columns[0] == $this->name) {
            return true;
        }

        return false;
    }

    public function uniqueKey(): bool
    {
        $indexes = $this->tableDetails->introspectTable($this->tableName)->getIndexes();
        foreach ($indexes as  $index) {
            if (!$index->isUnique())  continue;
            $columnsIndex = $index->getColumns();
            if (count($columnsIndex) == 1 && $columnsIndex[0] == $this->name) {
                return true;
            }
        }
        return false;
    }

    public function foreignKey(): ?ForeingKey
    {
        $foreignKeys = $this->tableDetails->listTableForeignKeys($this->tableName);
        foreach ($foreignKeys as $foreignKey) {
            $localColumns = $foreignKey->getLocalColumns();
            $foreignColumns = $foreignKey->getForeignColumns();

            if (in_array($this->name, $localColumns, true)) {
                $index = array_search($this->name, $localColumns);
                $referencedColumnName = $foreignColumns[$index];
                return new ForeingKey($foreignKey->getForeignTableName(), $referencedColumnName);
            }
        }

        return null;
    }
}
