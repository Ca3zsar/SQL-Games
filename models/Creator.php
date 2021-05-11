<?php


namespace app\models;

use app\core\DBModel;
use app\core\Model;

class Creator extends DBModel
{
    public string $title='';
    public string $difficulty='';
    public int $authorId;
    public int $price;
    public string $requirement='';
    public string $correctQuery='';
    public function rules(): array
    {
        return ['difficulty' => [self::RULE_REQUIRED],
            'exercise-title' => [self::RULE_REQUIRED],
            'requirement' =>[self::RULE_REQUIRED],
            'slider' => [self::RULE_REQUIRED],
            'correct-solve' => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string
    {
        return 'unverifiedex';
    }

    public function attributes(): array
    {
        return ['title','difficulty','authorId','price','requirement','correctQuery'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }


}