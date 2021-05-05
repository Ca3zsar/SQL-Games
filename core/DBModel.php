<?php


namespace app\core;


use PDOStatement;

abstract class DBModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attribute) => ":$attribute", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ")");
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute",$this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    public static function prepare($sqlStatement): bool|PDOStatement
    {
        return Application::$app->db->pdo->prepare($sqlStatement);
    }
}