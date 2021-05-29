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
    public int $id;

    static public array $allAchievements;

    static public History $history;

    static public function getEarly()
    {
        $statement = Application::$app->db->prepare("SELECT COUNT(*) firstSolved FROM solutions WHERE idUser = :id AND firstSolver = 1");
        $statement->bindValue(":id", Application::$app->user->id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result["firstSolved"];
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

    static public function hasAchieved($achievementId)
    {
        $statement = Application::$app->db->prepare("SELECT * FROM userachievements WHERE idAchievement = :idAch AND idUser = :idUser");
        $statement->bindValue(":idUser", Application::$app->user->id);
        $statement->bindValue(":idAch", $achievementId);

        $statement->execute();
        $result = $statement->fetch();
        if (!empty($result)) {
            return true;
        }
        return false;
    }

    static public function getCreated()
    {
        $statement = Application::$app->db->prepare("SELECT COUNT(*) created FROM exercises WHERE authorId = :id");
        $statement->bindValue(":id", Application::$app->user->id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result["created"];
    }

    static public function readAchievements()
    {
        Achievements::$history = new History;
        Achievements::$history->loadHistory(Application::$app->user->id);

        $statement = Application::$app->db->prepare("SELECT * FROM achievements");
        $statement->execute();

        Achievements::$allAchievements = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    static public function updateAchievements($idUser)
    {
        Achievements::readAchievements();
        foreach (Achievements::$allAchievements as $achievement) {
            $achievement->current = call_user_func(array(static::class, $achievement->required));
            if (!Achievements::hasAchieved($achievement->id)) {
                if ($achievement->current >= $achievement->target) {
                    $statement = Application::$app->db->prepare("INSERT INTO userachievements(idUser, idAchievement) VALUES(:idUser, :idAch)");

                    $statement->bindValue(':idUser', $idUser);
                    $statement->bindValue(':idAch', $achievement->id);

                    $statement->execute();
                }
            }
        }
    }

    static public function loadAchievements()
    {
        Achievements::readAchievements();
        foreach (Achievements::$allAchievements as $achievement) {
            $achievement->current = call_user_func(array(static::class, $achievement->required));
            if (!Achievements::hasAchieved($achievement->id)) {
                $achievement->image = "lock.png";
            }else{
                $achievement->current = $achievement->target;
            }
        }

        return Achievements::$allAchievements;
    }

    public function tableName(): string
    {
        return 'achievements';
    }

    public function attributes(): array
    {
        return [];
    }

    public function primaryKey(): string
    {
        return 'id';
    }
}