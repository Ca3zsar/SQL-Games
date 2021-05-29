<?php


namespace app\models;

use app\core\Application;
use app\core\DBModel;
use PDO;

class Achievements extends DBModel
{
    public string $name;
    public string $description;
    public string $image;
    public string $required;
    public int $target;
    public int $current;

    static public History $history;

    static public function getEarly()
    {
        $statement = Application::$app->db->prepare("SELECT COUNT(*) firstSolved FROM solutions WHERE idUser = :id AND firstSolver = 1");
        $statement->bindValue(":id",Application::$app->user->id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result != null && !empty($result)) {
            return $result["firstSolved"];
        }
    }

    static public function getSolved()
    {
        return Achievements::$history->solved;
    }

    static public function getStars()
    {
        return Achievements::$history->starsReceived;
    }

    static public function getCoins()
    {
        return Application::$app->user->coins;
    }

    static public function getCreated()
    {
        $statement = Application::$app->db->prepare("SELECT COUNT(*) created FROM exercises WHERE authorId = :id");
        $statement->bindValue(":id",Application::$app->user->id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result["created"];
    }

    static public function loadAchievements()
    {
        Achievements::$history = new History;
        Achievements::$history->loadHistory(Application::$app->user->id);

        $statement = Application::$app->db->prepare("SELECT * FROM achievements");
        $statement->execute();

        $allAchievements = $statement->fetchAll(PDO::FETCH_CLASS,static::class);
        foreach($allAchievements as $achievement)
        {
            $achievement->current = call_user_func(array(static::class,$achievement->required));
        }

        return $allAchievements;
    }

    public function tableName(): string
    {
        return 'achievements';
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