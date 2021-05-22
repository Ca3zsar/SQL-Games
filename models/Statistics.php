<?php


namespace app\models;


class Statistics extends \app\core\DBModel
{
    public array $stats;

    public function loadStats()
    {

    }

    public function tableName(): string
    {
        return "users";
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }

    public function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
    }

    public function rules(): array
    {
        return [];
    }
}