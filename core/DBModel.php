<?php


namespace app\core;


abstract class DBModel extends Model
{
    abstract public function tableName (): string;

    abstract public function attributes(): array;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

    }

    public function prepare($sqlStatement)
    {
        return Application::$app->db->pdo->prepare($sqlStatement);
    }
}