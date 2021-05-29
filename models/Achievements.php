<?php


namespace app\models;


use app\core\DBModel;

class Achievements extends DBModel
{
    public string $name;
    public string $description;
    public string $image;
    public int $target;
    public int $id;

    static public function loadAchievements()
    {
        lo
    }

    public function tableName(): string
    {
        // TODO: Implement tableName() method.
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }

    public function primaryKey(): string
    {
        return 'id';
    }
}