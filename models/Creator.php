<?php


namespace app\models;

use app\core\Application;
use app\core\DBModel;
use app\core\Model;

class Creator extends DBModel
{
    public string $title = '';
    public string $difficulty = '';
    public int $authorId = 0;
    public int $exerciseId = 0;
    public int $price = 3;
    public string $requirement = '';
    public string $correctQuery = '';

    public function __construct(Exercise $exercise=null)
    {
        if($exercise != null) {
            $this->exerciseId = $exercise->id;
            $this->authorId = $exercise->authorId;
            $this->title = $exercise->title;
            $this->price = $exercise->price;
            $this->requirement = $exercise->requirement;
            $this->correctQuery = Exercise::getCorrectQuery($exercise->id);
            $this->difficulty = $exercise->difficulty;
        }
    }

    public function rules(): array
    {
        return ['difficulty' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED, [self::RULE_TITLE_UNIQUE, 'class' => self::class]],
            'requirement' => [self::RULE_REQUIRED, [self::RULE_MIN_TEXT, 'min' => 20]],
            'price' => [self::RULE_REQUIRED]
        ];
    }

    public function addExercise(): bool
    {
        return parent::save();
    }

    public function tableName(): string
    {
        return 'exercises';
    }

    public function attributes(): array
    {
        return ['title', 'difficulty', 'authorId', 'price', 'requirement', 'correctQuery'];
    }

    public function primaryKey(): string
    {
            return 'id';
    }

    static public function isExerciseAuthor($exerciseId)
    {
        $userId = Application::$app->session->get('user');
        $sql = Application::$app->db->prepare("select * from exercises where id = :id and authorId = :authorId");
        $sql->bindValue(':id', $exerciseId);
        $sql->bindValue(':authorId', $userId);
        $sql->execute();
        $result = $sql->fetch();

        if(!empty($result))
        {
            return true;
        }

        return false;

    }

}