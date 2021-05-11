<?php


namespace app\models;

use app\core\DBModel;
use app\core\Model;

class Creator extends DBModel
{
    public string $title = '';
    public string $difficulty = '';
    public int $authorId;
    public int $price = 0;
    public string $requirement = '';
    public string $correctQuery = '';

    public function __construct($userId)
    {
        $this->authorId = $userId;
    }

    public function rules(): array
    {
        return ['difficulty' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED, [self::RULE_TITLE_UNIQUE, 'class' => self::class]],
            'requirement' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 20]],
            'price' => [self::RULE_REQUIRED]
        ];
    }

    public function addUnverified(): bool
    {
        return parent::save();
    }

    public function tableName(): string
    {
        return 'unverifiedex';
    }

    public function attributes(): array
    {
        return ['title', 'difficulty', 'authorId', 'price', 'requirement', 'correctQuery'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }


}